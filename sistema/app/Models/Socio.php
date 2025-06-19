<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Socio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'cpf',
        'telefone',
        'email',
        'data_nascimento',
        'ativo',
        'bloqueado_ate'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'bloqueado_ate' => 'date',
        'ativo' => 'boolean'
    ];

    // public function mensalidades()
    // {
    //     return $this->hasMany(Mensalidade::class);
    // }

    public function isBloqueado()
    {
        return $this->bloqueado_ate && $this->bloqueado_ate->isFuture();
    }

    public function temMensalidadeAtrasada()
    {
        // return $this->mensalidades()
          //   ->where('status', 'atrasado')
         //    ->where('data_vencimento', '<', Carbon::now()->subDays(60))
          //   ->exists();
          return false; // Implementar lógica de mensalidades
    }

    public static function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) != 11) {
            return false;
        }
        
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        
        return true;
    }
}
