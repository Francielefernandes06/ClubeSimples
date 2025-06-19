<?php

namespace App\Http\Controllers;

use App\Models\Mensalidade;
use App\Models\Socio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MensalidadeController extends Controller
{
    public function index(Request $request)
    {
        $query = Mensalidade::with('socio');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('mes')) {
            $query->where('mes', $request->mes);
        }

        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        if ($request->filled('socio')) {
            $query->whereHas('socio', function($q) use ($request) {
                $q->where('nome_completo', 'like', '%' . $request->socio . '%');
            });
        }

        $mensalidades = $query->orderBy('ano', 'desc')
                             ->orderBy('mes', 'desc')
                             ->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Mensalidade::count(),
            'pagas' => Mensalidade::where('status', 'pago')->count(),
            'pendentes' => Mensalidade::where('status', 'pendente')->count(),
            'atrasadas' => Mensalidade::where('status', 'atrasado')->count(),
            'valor_total' => Mensalidade::where('status', 'pago')->sum('valor'),
            'multas_total' => Mensalidade::sum('multa')
        ];

        return view('admin.mensalidades.index', compact('mensalidades', 'stats'));
    }

    public function create()
    {
        $socios = Socio::where('ativo', true)->orderBy('nome_completo')->get();
        return view('admin.mensalidades.create', compact('socios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'valor' => 'required|numeric|min:0',
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'data_vencimento' => 'required|date'
        ]);

        // Verificar se já existe mensalidade para este sócio no período
        $existente = Mensalidade::where('socio_id', $validated['socio_id'])
                                ->where('mes', $validated['mes'])
                                ->where('ano', $validated['ano'])
                                ->exists();

        if ($existente) {
            return back()->withErrors(['mes' => 'Já existe uma mensalidade para este sócio neste período.']);
        }

        Mensalidade::create($validated);

        return redirect()->route('mensalidades.index')
            ->with('success', 'Mensalidade registrada com sucesso!');
    }

    public function show(Mensalidade $mensalidade)
    {
        return view('admin.mensalidades.show', compact('mensalidade'));
    }

    public function edit(Mensalidade $mensalidade)
    {
        $socios = Socio::where('ativo', true)->orderBy('nome_completo')->get();
        return view('admin.mensalidades.edit', compact('mensalidade', 'socios'));
    }

    public function update(Request $request, Mensalidade $mensalidade)
    {
        $validated = $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'valor' => 'required|numeric|min:0',
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'status' => 'required|in:pendente,pago,atrasado'
        ]);

        // Verificar se já existe mensalidade para este sócio no período (exceto a atual)
        $existente = Mensalidade::where('socio_id', $validated['socio_id'])
                                ->where('mes', $validated['mes'])
                                ->where('ano', $validated['ano'])
                                ->where('id', '!=', $mensalidade->id)
                                ->exists();

        if ($existente) {
            return back()->withErrors(['mes' => 'Já existe uma mensalidade para este sócio neste período.']);
        }

        // Calcular multa se necessário
        if ($validated['status'] === 'atrasado' && !$validated['data_pagamento']) {
            $validated['multa'] = $mensalidade->calcularMulta();
        } elseif ($validated['status'] === 'pago') {
            $validated['multa'] = 0;
        }

        $mensalidade->update($validated);

        return redirect()->route('mensalidades.index')
            ->with('success', 'Mensalidade atualizada com sucesso!');
    }

    public function destroy(Mensalidade $mensalidade)
    {
        $mensalidade->delete();

        return redirect()->route('mensalidades.index')
            ->with('success', 'Mensalidade excluída com sucesso!');
    }

    public function marcarPago(Request $request, Mensalidade $mensalidade)
    {
        $validated = $request->validate([
            'data_pagamento' => 'required|date'
        ]);

        $mensalidade->update([
            'data_pagamento' => $validated['data_pagamento'],
            'status' => 'pago',
            'multa' => 0
        ]);

        return back()->with('success', 'Pagamento registrado com sucesso!');
    }

    public function inadimplentes()
    {
        $inadimplentes = Socio::whereHas('mensalidades', function($query) {
            $query->where('status', 'atrasado')
                  ->where('data_vencimento', '<', Carbon::now()->subDays(10));
        })->with(['mensalidades' => function($query) {
            $query->where('status', 'atrasado')
                  ->orderBy('data_vencimento');
        }])->get();

        return view('admin.mensalidades.inadimplentes', compact('inadimplentes'));
    }

    public function gerarMensalidadesMes(Request $request)
    {
        $validated = $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'valor' => 'required|numeric|min:0',
            'dia_vencimento' => 'required|integer|min:1|max:31'
        ]);

        $sociosAtivos = Socio::where('ativo', true)->get();
        $geradas = 0;

        foreach ($sociosAtivos as $socio) {
            // Verificar se já existe mensalidade para este período
            $existe = Mensalidade::where('socio_id', $socio->id)
                                 ->where('mes', $validated['mes'])
                                 ->where('ano', $validated['ano'])
                                 ->exists();

            if (!$existe) {
                $dataVencimento = Carbon::create(
                    $validated['ano'], 
                    $validated['mes'], 
                    $validated['dia_vencimento']
                );

                Mensalidade::create([
                    'socio_id' => $socio->id,
                    'valor' => $validated['valor'],
                    'mes' => $validated['mes'],
                    'ano' => $validated['ano'],
                    'data_vencimento' => $dataVencimento,
                    'status' => 'pendente'
                ]);

                $geradas++;
            }
        }

        return back()->with('success', "Foram geradas {$geradas} mensalidades para o período {$validated['mes']}/{$validated['ano']}.");
    }
}
