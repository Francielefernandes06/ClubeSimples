<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mensalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'socio_id',
        'valor',
        'multa',
        'mes',
        'ano',
        'data_vencimento',
        'data_pagamento',
        'status'
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
        'valor' => 'decimal:2',
        'multa' => 'decimal:2'
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }



    public function boleto()
    {
        return $this->hasOne(Boleto::class);
    }

    public function temBoleto()
    {
        return $this->boleto()->exists();
    }

    public function getValorTotalComMulta()
    {
        return $this->valor + $this->multa;
    }
    public function calcularMulta()
    {
        if ($this->status === 'pago') {
            return 0;
        }

        $diasAtraso = Carbon::now()->diffInDays($this->data_vencimento, false);
        
        if ($diasAtraso > 10) {
            return $this->valor * 0.02; // 2% de multa
        }

        return 0;
    }

    public function atualizarStatus()
    {
        if ($this->data_pagamento) {
            $this->status = 'pago';
        } elseif (Carbon::now()->gt($this->data_vencimento)) {
            $this->status = 'atrasado';
            $this->multa = $this->calcularMulta();
        }

        $this->save();
    }
}
