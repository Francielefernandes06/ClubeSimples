<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Mensalidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class BoletoController extends Controller
{
    private $chavePix = '12345678901'; // Chave PIX do clube
    private $nomeRecebedor = 'CLUBE EXEMPLO LTDA';
    private $cidade = 'SAO PAULO';

    public function index(Request $request)
    {
        $query = Boleto::with(['mensalidade.socio']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('mes')) {
            $query->whereHas('mensalidade', function($q) use ($request) {
                $q->where('mes', $request->mes);
            });
        }

        if ($request->filled('ano')) {
            $query->whereHas('mensalidade', function($q) use ($request) {
                $q->where('ano', $request->ano);
            });
        }

        $boletos = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Boleto::count(),
            'pendentes' => Boleto::where('status', 'pendente')->count(),
            'enviados' => Boleto::where('status', 'enviado')->count(),
            'pagos' => Boleto::where('status', 'pago')->count(),
            'vencidos' => Boleto::where('status', 'vencido')->count(),
            'valor_total' => Boleto::where('status', '!=', 'pago')->sum('valor_total')
        ];

        return view('boletos.index', compact('boletos', 'stats'));
    }

    public function gerar(Mensalidade $mensalidade)
    {
        // Verificar se já existe boleto
        if ($mensalidade->temBoleto()) {
            return back()->with('error', 'Esta mensalidade já possui um boleto gerado.');
        }

        // Criar boleto
        $boleto = Boleto::create([
            'mensalidade_id' => $mensalidade->id,
            'numero_boleto' => '',
            'valor_total' => $mensalidade->getValorTotalComMulta(),
            'data_vencimento' => $mensalidade->data_vencimento,
        ]);

        // Gerar número do boleto
        $boleto->numero_boleto = $boleto->gerarNumeroBoleto();
        
        // Gerar QR Code PIX
        $boleto->qr_code_pix = $boleto->gerarQRCodePix(
            $this->chavePix,
            $this->nomeRecebedor,
            $this->cidade
        );

        $boleto->save();

        // Gerar PDF
        $this->gerarPDF($boleto);

        return back()->with('success', 'Boleto gerado com sucesso!');
    }

    public function gerarPDF(Boleto $boleto)
    {
        // Gerar QR Code como imagem
        $qrCodeImage = QrCode::format('png')
            ->size(150)
            ->generate($boleto->qr_code_pix);

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);

        // Dados para o PDF
        $data = [
            'boleto' => $boleto,
            'mensalidade' => $boleto->mensalidade,
            'socio' => $boleto->mensalidade->socio,
            'qrCodeImage' => $qrCodeBase64,
            'chavePix' => $this->chavePix,
            'nomeRecebedor' => $this->nomeRecebedor
        ];

        // Gerar PDF
        $pdf = Pdf::loadView('boletos.pdf', $data);
        
        // Salvar arquivo
        $nomeArquivo = "boleto_{$boleto->numero_boleto}.pdf";
        $caminhoArquivo = "boletos/{$nomeArquivo}";
        
        Storage::put($caminhoArquivo, $pdf->output());
        
        // Atualizar boleto com caminho do arquivo
        $boleto->update(['arquivo_pdf' => $caminhoArquivo]);

        return $pdf;
    }

    public function download(Boleto $boleto)
    {
        if (!$boleto->arquivo_pdf || !Storage::exists($boleto->arquivo_pdf)) {
            $this->gerarPDF($boleto);
        }

        return Storage::download($boleto->arquivo_pdf, "boleto_{$boleto->numero_boleto}.pdf");
    }

    public function enviarEmail(Boleto $boleto)
    {
        try {
            // Verificar se pode reenviar
            if (!$boleto->podeReenviar()) {
                return back()->with('error', 'Limite de tentativas de envio excedido ou boleto já pago.');
            }

            // Gerar PDF se não existir
            if (!$boleto->arquivo_pdf || !Storage::exists($boleto->arquivo_pdf)) {
                $this->gerarPDF($boleto);
            }

            // Enviar email
            Mail::send('emails.boleto', [
                'boleto' => $boleto,
                'socio' => $boleto->mensalidade->socio,
                'mensalidade' => $boleto->mensalidade
            ], function ($message) use ($boleto) {
                $message->to($boleto->mensalidade->socio->email)
                        ->subject('Boleto de Mensalidade - ' . $boleto->numero_boleto)
                        ->attach(Storage::path($boleto->arquivo_pdf));
            });

            // Atualizar status
            $boleto->update([
                'status' => 'enviado',
                'enviado_em' => now(),
                'tentativas_envio' => $boleto->tentativas_envio + 1
            ]);

            return back()->with('success', 'Boleto enviado por email com sucesso!');

        } catch (\Exception $e) {
            // Incrementar tentativas mesmo em caso de erro
            $boleto->increment('tentativas_envio');
            
            return back()->with('error', 'Erro ao enviar email: ' . $e->getMessage());
        }
    }

    public function reenviar(Boleto $boleto)
    {
        return $this->enviarEmail($boleto);
    }

    public function marcarPago(Boleto $boleto)
    {
        $boleto->update(['status' => 'pago']);
        
        // Atualizar mensalidade
        $boleto->mensalidade->update([
            'status' => 'pago',
            'data_pagamento' => now()
        ]);

        return back()->with('success', 'Boleto marcado como pago!');
    }

    public function destroy(Boleto $boleto)
    {
        // Remover arquivo PDF
        if ($boleto->arquivo_pdf && Storage::exists($boleto->arquivo_pdf)) {
            Storage::delete($boleto->arquivo_pdf);
        }

        $boleto->delete();

        return back()->with('success', 'Boleto excluído com sucesso!');
    }

    public function segundaVia(Mensalidade $mensalidade)
    {
        if (!$mensalidade->temBoleto()) {
            return back()->with('error', 'Esta mensalidade não possui boleto gerado.');
        }

        return $this->download($mensalidade->boleto);
    }

    public function gerarLote(Request $request)
    {
        $validated = $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'enviar_email' => 'boolean'
        ]);

        $mensalidades = Mensalidade::where('mes', $validated['mes'])
                                  ->where('ano', $validated['ano'])
                                  ->where('status', '!=', 'pago')
                                  ->whereDoesntHave('boleto')
                                  ->with('socio')
                                  ->get();

        $gerados = 0;
        $enviados = 0;

        foreach ($mensalidades as $mensalidade) {
            // Criar boleto
            $boleto = Boleto::create([
                'mensalidade_id' => $mensalidade->id,
                'numero_boleto' => '',
                'valor_total' => $mensalidade->getValorTotalComMulta(),
                'data_vencimento' => $mensalidade->data_vencimento,
            ]);

            // Gerar número e QR Code
            $boleto->numero_boleto = $boleto->gerarNumeroBoleto();
            $boleto->qr_code_pix = $boleto->gerarQRCodePix(
                $this->chavePix,
                $this->nomeRecebedor,
                $this->cidade
            );
            $boleto->save();

            // Gerar PDF
            $this->gerarPDF($boleto);
            $gerados++;

            // Enviar email se solicitado
            if ($validated['enviar_email'] ?? false) {
                try {
                    $this->enviarEmail($boleto);
                    $enviados++;
                } catch (\Exception $e) {
                    // Log do erro mas continua o processo
                    \Log::error("Erro ao enviar boleto {$boleto->numero_boleto}: " . $e->getMessage());
                }
            }
        }

        $mensagem = "Foram gerados {$gerados} boletos.";
        if ($validated['enviar_email'] ?? false) {
            $mensagem .= " {$enviados} foram enviados por email.";
        }

        return back()->with('success', $mensagem);
    }
}
