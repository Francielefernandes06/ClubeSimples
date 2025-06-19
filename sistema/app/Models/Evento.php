<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data',
        'horario',
        'local',
        'limite_participantes',
        'participantes_inscritos',
        'ativo',
        'imagem'
    ];

    protected $casts = [
        'data' => 'date',
        'horario' => 'datetime:H:i',
        'ativo' => 'boolean'
    ];

    public function temVagas()
    {
        return $this->participantes_inscritos < $this->limite_participantes;
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeFuturos($query)
    {
        return $query->where('data', '>=', now()->toDateString());
    }
}
