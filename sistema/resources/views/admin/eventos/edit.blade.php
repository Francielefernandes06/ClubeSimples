
<x-layouts.app :title="__('Editar Evento - Admin')">

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Editar Dados do Evento</h2>
            <a href="{{ route('admin.eventos.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        <form method="POST" action="{{ route('admin.eventos.update', $evento) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome do Evento *
                </label>
                <input type="text" name="nome" id="nome" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nome') border-red-500 @enderror"
                       value="{{ old('nome', $evento->nome) }}" placeholder="Digite o nome do evento">
                @error('nome')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                    Descrição
                </label>
                <textarea name="descricao" id="descricao" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('descricao') border-red-500 @enderror"
                          placeholder="Descreva o evento...">{{ old('descricao', $evento->descricao) }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700 mb-2">
                        Data *
                    </label>
                    <input type="date" name="data" id="data" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('data') border-red-500 @enderror"
                           value="{{ old('data', $evento->data->format('Y-m-d')) }}">
                    @error('data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="horario" class="block text-sm font-medium text-gray-700 mb-2">
                        Horário *
                    </label>
                    <input type="time" name="horario" id="horario" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('horario') border-red-500 @enderror"
                           value="{{ old('horario', $evento->horario->format('H:i')) }}">
                    @error('horario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="local" class="block text-sm font-medium text-gray-700 mb-2">
                        Local *
                    </label>
                    <input type="text" name="local" id="local" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('local') border-red-500 @enderror"
                           value="{{ old('local', $evento->local) }}" placeholder="Local do evento">
                    @error('local')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="limite_participantes" class="block text-sm font-medium text-gray-700 mb-2">
                        Limite de Participantes *
                    </label>
                    <input type="number" name="limite_participantes" id="limite_participantes" required min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('limite_participantes') border-red-500 @enderror"
                           value="{{ old('limite_participantes', $evento->limite_participantes) }}" placeholder="Ex: 50">
                    @error('limite_participantes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">
                    Imagem do Evento
                </label>
                
                @if($evento->imagem)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                        <img src="{{ Storage::url($evento->imagem) }}" alt="{{ $evento->nome }}" 
                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                    </div>
                @endif
                
                <input type="file" name="imagem" id="imagem" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('imagem') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">
                    Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB
                    @if($evento->imagem)
                        <br><span class="text-yellow-600">Deixe em branco para manter a imagem atual</span>
                    @endif
                </p>
                @error('imagem')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status do Evento -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status do Evento
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="radio" name="ativo" value="1" 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                               {{ old('ativo', $evento->ativo) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Ativo</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="ativo" value="0" 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                               {{ !old('ativo', $evento->ativo) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Inativo</span>
                    </label>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Informações do Evento</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Participantes Inscritos:</span>
                        <span class="font-medium text-gray-900">{{ $evento->participantes_inscritos }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Vagas Restantes:</span>
                        <span class="font-medium {{ $evento->temVagas() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $evento->limite_participantes - $evento->participantes_inscritos }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">Criado em:</span>
                        <span class="font-medium text-gray-900">{{ $evento->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Última atualização:</span>
                        <span class="font-medium text-gray-900">{{ $evento->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.eventos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-black text-gray-700 hover:bg-gray-50 font-medium transition duration-150">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview da nova imagem
document.getElementById('imagem').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Remove preview anterior se existir
            const existingPreview = document.getElementById('imagePreview');
            if (existingPreview) {
                existingPreview.remove();
            }
            
            // Cria novo preview
            const preview = document.createElement('div');
            preview.id = 'imagePreview';
            preview.className = 'mt-2';
            preview.innerHTML = `
                <p class="text-sm text-gray-600 mb-2">Nova imagem:</p>
                <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
            `;
            
            // Insere o preview após o input
            e.target.parentNode.insertBefore(preview, e.target.nextSibling);
        };
        reader.readAsDataURL(file);
    }
});

// Validação de conflito de horário/local
document.getElementById('data').addEventListener('change', checkConflict);
document.getElementById('horario').addEventListener('change', checkConflict);
document.getElementById('local').addEventListener('change', checkConflict);

function checkConflict() {
    const data = document.getElementById('data').value;
    const horario = document.getElementById('horario').value;
    const local = document.getElementById('local').value;
    
    if (data && horario && local) {
        // Aqui você pode implementar uma verificação AJAX para conflitos
        // Por enquanto, apenas um exemplo visual
        console.log('Verificando conflitos para:', { data, horario, local });
    }
}
</script>
</x-layouts.app>
