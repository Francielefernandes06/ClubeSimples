<?php

namespace App\Http\Controllers;

use Carbon\Carbon;



class HomeController extends Controller
{
    public function index()
    {
        $eventosDestaque = collect([
            (object)[
                'imagem' => 'eventos/tecnologia.jpg',
                'nome' => 'Evento de Tecnologia',
                'descricao' => 'Um evento sobre as últimas inovações em tecnologia.',
                'data' => Carbon::parse('2025-07-10'),
                'horario' => Carbon::parse('2025-07-10 19:00:00'),
                'local' => 'Centro de Convenções',
                'participantes_inscritos' => 50,
                'limite_participantes' => 100,
                'temVagas' => fn () => 50 < 100,
            ],
            (object)[
                'imagem' => null, // Para testar fallback do ícone
                'nome' => 'Festa Junina do Clube',
                'descricao' => 'Comidas típicas, música ao vivo e muita diversão!',
                'data' => Carbon::parse('2025-07-20'),
                'horario' => Carbon::parse('2025-07-20 17:30:00'),
                'local' => 'Quadra Principal',
                'participantes_inscritos' => 200,
                'limite_participantes' => 200,
                'temVagas' => fn () => 100 < 200,
            ]
        ]);

        return view('welcome', compact('eventosDestaque'));
    }
}
