
<x-layouts.app :title="__('Novo Evento - Admin')">

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Dados do Evento</h2>
        </div>

        <form method="POST" action="{{ route('admin.eventos.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome do Evento *
                </label>
                <input type="text" name="nome" id="nome" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nome') border-red-500 @enderror"
                       value="{{ old('nome') }}" placeholder="Digite o nome do evento">
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
                          placeholder="Descreva o evento...">{{ old('descricao') }}</textarea>
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
                           value="{{ old('data') }}" min="{{ date('Y-m-d') }}">
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
                           value="{{ old('horario') }}">
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
                           value="{{ old('local') }}" placeholder="Local do evento">
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
                           value="{{ old('limite_participantes') }}" placeholder="Ex: 50">
                    @error('limite_participantes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">
                    Imagem do Evento
                </label>
                <input type="file" name="imagem" id="imagem" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('imagem') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</p>
                @error('imagem')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.eventos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-black text-gray-700 hover:bg-gray-50 font-medium transition duration-150">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Cadastrar Evento
                </button>
            </div>
        </form>
    </div>
</div>
</x-layouts.app>
