<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function public()
    {
        $eventos = Evento::ativos()
            ->futuros()
            ->orderBy('data')
            ->paginate(12);

        return view('eventos.public', compact('eventos'));
    }

    public function index()
    {
        $eventos = Evento::orderBy('data', 'desc')->paginate(10);
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('admin.eventos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data' => 'required|date|after:today',
            'horario' => 'required',
            'local' => 'required|string|max:255',
            'limite_participantes' => 'required|integer|min:1',
            'imagem' => 'nullable|image|max:2048'
        ]);

        // Verificar conflito de local/horário
        $conflito = Evento::where('local', $validated['local'])
            ->where('data', $validated['data'])
            ->where('horario', $validated['horario'])
            ->exists();

        if ($conflito) {
            return back()->withErrors(['local' => 'Já existe um evento neste local e horário.']);
        }

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        Evento::create($validated);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Evento $evento)
    {
        return view('admin.eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data' => 'required|date',
            'horario' => 'required',
            'local' => 'required|string|max:255',
            'limite_participantes' => 'required|integer|min:1',
            'imagem' => 'nullable|image|max:2048'
        ]);

        // Verificar conflito de local/horário (exceto o próprio evento)
        $conflito = Evento::where('local', $validated['local'])
            ->where('data', $validated['data'])
            ->where('horario', $validated['horario'])
            ->where('id', '!=', $evento->id)
            ->exists();

        if ($conflito) {
            return back()->withErrors(['local' => 'Já existe um evento neste local e horário.']);
        }

        if ($request->hasFile('imagem')) {
            if ($evento->imagem) {
                Storage::disk('public')->delete($evento->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        $evento->update($validated);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        if ($evento->imagem) {
            Storage::disk('public')->delete($evento->imagem);
        }
        
        $evento->delete();

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento excluído com sucesso!');
    }
}
