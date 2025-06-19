<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class CarteirinhaController extends Controller
{
    public function show(Request $request, Socio $socio)
    {
        // Verificar se o sócio está ativo
        if (!$socio->ativo) {
            return redirect()->back()->with('error', 'Sócio inativo não pode acessar a carteirinha.');
        }

        // Verificar se está adimplente
        if (!$socio->isAdimplente()) {
            return view('socio.carteirinha-bloqueada', compact('socio'));
        }

        // Gerar QR Code com link de validação
        $validationUrl = route('carteirinha.validar', ['socio' => $socio->id, 'token' => md5($socio->cpf . $socio->created_at)]);
        $qrCode = QrCode::size(150)->generate($validationUrl);

        return view('socio.carteirinha', compact('socio', 'qrCode'));
    }

    public function downloadPdf(Socio $socio)
    {
        // Verificar se o sócio está ativo e adimplente
        if (!$socio->ativo || !$socio->isAdimplente()) {
            return redirect()->back()->with('error', 'Não é possível gerar PDF da carteirinha.');
        }

        // Gerar QR Code
        $validationUrl = route('carteirinha.validar', ['socio' => $socio->id, 'token' => md5($socio->cpf . $socio->created_at)]);
        $qrCode = base64_encode(QrCode::size(150)->generate($validationUrl));

        $pdf = Pdf::loadView('socio.carteirinha-pdf', compact('socio', 'qrCode'));
        
        return $pdf->download('carteirinha-' . $socio->getNumeroMatricula() . '.pdf');
    }

    public function validar(Request $request, Socio $socio)
    {
        $token = $request->get('token');
        $decoded = base64_decode($token); 
        list($id, $timestamp) = explode('_', $decoded);

        if ($socio->id != $id) {
            return response()->json(['valid' => false, 'message' => 'Token inválido'], 400);
        }

        return response()->json([
            'valid' => true,
            'socio' => [
                'nome' => $socio->nome_completo,
                'matricula' => $socio->getNumeroMatricula(),
                'status' => $socio->ativo && $socio->isAdimplente() ? 'Ativo' : 'Inativo',
                'validade' => $socio->getValidadeCarteirinha()->format('d/m/Y')
            ]
        ]);
    }

    public function index()
    {
        $socios = Socio::where('ativo', true)->orderBy('nome_completo')->paginate(20);
        return view('admin.carteirinhas.index', compact('socios'));
    }
}
