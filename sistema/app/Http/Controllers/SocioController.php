<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function index()
    {
        $socios = Socio::orderBy('nome_completo')->paginate(10);
        return view('admin.socios.index', compact('socios'));
    }

    public function create()
    {
        return view('admin.socios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:socios,cpf',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|unique:socios,email',
            'data_nascimento' => 'required|date|before:today'
        ]);

        // Validar CPF
        if (!Socio::validarCPF($validated['cpf'])) {
            return back()->withErrors(['cpf' => 'CPF inválido.']);
        }

        Socio::create($validated);

        return redirect()->route('socios.index')
            ->with('success', 'Sócio cadastrado com sucesso!');
    }

    public function show(Socio $socio)
    {
       $mensalidades = $socio->mensalidades()
           ->orderBy('ano', 'desc')
           ->orderBy('mes', 'desc')
           ->get();

        return view('admin.socios.show', compact('socio',  'mensalidades' ));
    }

    public function edit(Socio $socio)
    {
        return view('admin.socios.edit', compact('socio'));
    }

    public function update(Request $request, Socio $socio)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:socios,cpf,' . $socio->id,
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|unique:socios,email,' . $socio->id,
            'data_nascimento' => 'required|date|before:today'
        ]);

        // Validar CPF
        if (!Socio::validarCPF($validated['cpf'])) {
            return back()->withErrors(['cpf' => 'CPF inválido.']);
        }

        $socio->update($validated);

        return redirect()->route('socios.index')
            ->with('success', 'Sócio atualizado com sucesso!');
    }

    public function destroy(Socio $socio)
    {
        $socio->delete();

        return redirect()->route('socios.index')
            ->with('success', 'Sócio excluído com sucesso!');
    }
}
