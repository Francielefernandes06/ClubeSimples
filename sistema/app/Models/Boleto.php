<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Boleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'mensalidade_id',
        'numero_boleto',
        'arquivo_pdf',
        'qr_code_pix',
        'valor_total',
        'data_vencimento',
        'enviado_em',
        'tentativas_envio',
        'status'
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'enviado_em' => 'datetime',
        'valor_total' => 'decimal:2'
    ];

    public function mensalidade()
    {
        return $this->belongsTo(Mensalidade::class);
    }

    public function gerarNumeroBoleto()
    {
        $ano = $this->data_vencimento->format('Y');
        $mes = $this->data_vencimento->format('m');
        $sequencial = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        
        return "CLB{$ano}{$mes}{$sequencial}";
    }

    public function gerarQRCodePix($chavePix, $nomeRecebedor, $cidade)
    {
        $valor = number_format($this->valor_total, 2, '.', '');
        $descricao = "Mensalidade " . $this->mensalidade->mes . "/" . $this->mensalidade->ano;
        
        // Payload PIX simplificado (EMV)
        $payload = "00020126";
        $payload .= "01041.0.0";
        $payload .= "26" . sprintf("%02d", strlen($chavePix) + 22) . "0014BR.GOV.BCB.PIX01" . sprintf("%02d", strlen($chavePix)) . $chavePix;
        $payload .= "52040000";
        $payload .= "5303986";
        $payload .= "54" . sprintf("%02d", strlen($valor)) . $valor;
        $payload .= "5802BR";
        $payload .= "59" . sprintf("%02d", strlen($nomeRecebedor)) . $nomeRecebedor;
        $payload .= "60" . sprintf("%02d", strlen($cidade)) . $cidade;
        $payload .= "62" . sprintf("%02d", strlen($descricao) + 4) . "05" . sprintf("%02d", strlen($descricao)) . $descricao;
        $payload .= "6304";
        
        // Calcular CRC16
        $crc = $this->calcularCRC16($payload);
        $payload .= strtoupper(dechex($crc));
        
        return $payload;
    }

    private function calcularCRC16($data)
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= ord($data[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
                $crc &= 0xFFFF;
            }
        }
        return $crc;
    }

    public function isVencido()
    {
        return $this->data_vencimento->isPast() && $this->status !== 'pago';
    }

    public function podeReenviar()
    {
        return $this->tentativas_envio < 3 && $this->status !== 'pago';
    }
}
