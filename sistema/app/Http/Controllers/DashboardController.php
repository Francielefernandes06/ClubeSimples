<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\Mensalidade;
use App\Models\Evento;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalSocios = Socio::count();
        $sociosAtivos = Socio::where('ativo', true)->count();
        $sociosBloqueados = Socio::where('bloqueado_ate', '>', now())->count();
        $totalEventos = Evento::count();

        // Estatísticas de mensalidades
        $mensalidadesStats = [
            'total' => Mensalidade::count(),
            'pagas' => Mensalidade::where('status', 'pago')->count(),
            'pendentes' => Mensalidade::where('status', 'pendente')->count(),
            'atrasadas' => Mensalidade::where('status', 'atrasado')->count(),
        ];

        // Receita mensal
        $receitaMensal = Mensalidade::where('status', 'pago')
            ->whereYear('data_pagamento', date('Y'))
            ->groupBy(DB::raw('MONTH(data_pagamento)'))
            ->orderBy(DB::raw('MONTH(data_pagamento)'))
            ->selectRaw('MONTH(data_pagamento) as mes, SUM(valor) as total')
            ->get()
            ->pluck('total', 'mes')
            ->toArray();

        // Preencher meses sem receita
        $receitaCompleta = [];
        for ($i = 1; $i <= 12; $i++) {
            $receitaCompleta[] = $receitaMensal[$i] ?? 0;
        }

        // Mensalidades por status (últimos 6 meses)
        $mensalidadesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $data->month;
            $ano = $data->year;
            
            $mensalidadesPorMes[] = [
                'mes' => $data->format('M/Y'),
                'pagas' => Mensalidade::where('mes', $mes)->where('ano', $ano)->where('status', 'pago')->count(),
                'pendentes' => Mensalidade::where('mes', $mes)->where('ano', $ano)->where('status', 'pendente')->count(),
                'atrasadas' => Mensalidade::where('mes', $mes)->where('ano', $ano)->where('status', 'atrasado')->count(),
            ];
        }

        // Próximos eventos
        $proximosEventos = Evento::where('data', '>=', now())
            ->orderBy('data')
            ->take(5)
            ->get();

        // Mensalidades vencendo (próximos 7 dias)
        $mensalidadesVencendo = Mensalidade::where('status', 'pendente')
            ->whereBetween('data_vencimento', [now(), now()->addDays(7)])
            ->with('socio')
            ->orderBy('data_vencimento')
            ->take(10)
            ->get();

        // Inadimplentes críticos (mais de 30 dias)
        $inadimplentes = Socio::whereHas('mensalidades', function($query) {
            $query->where('status', 'atrasado')
                  ->where('data_vencimento', '<', now()->subDays(30));
        })->with(['mensalidades' => function($query) {
            $query->where('status', 'atrasado')
                  ->orderBy('data_vencimento');
        }])->take(5)->get();

        // Crescimento de sócios (últimos 12 meses)
        $crescimentoSocios = [];
        for ($i = 11; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $count = Socio::whereYear('created_at', $data->year)
                          ->whereMonth('created_at', $data->month)
                          ->count();
            $crescimentoSocios[] = [
                'mes' => $data->format('M/Y'),
                'total' => $count
            ];
        }

        return view('dashboard', compact(
            'totalSocios',
            'sociosAtivos', 
            'sociosBloqueados',
            'totalEventos',
            'mensalidadesStats',
            'receitaCompleta',
            'mensalidadesPorMes',
            'proximosEventos',
            'mensalidadesVencendo',
            'inadimplentes',
            'crescimentoSocios'
        ));
    }
}
