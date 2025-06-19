<x-layouts.app :title="__('Editar Sócio - Admin')">

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Editar Dados do Sócio</h2>
            <a href="{{ route('socios.show', $socio) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        <form method="POST" action="{{ route('socios.update', $socio) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nome_completo" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome Completo *
                </label>
                <input type="text" name="nome_completo" id="nome_completo" required
                       class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nome_completo') border-red-500 @enderror"
                       value="{{ old('nome_completo', $socio->nome_completo) }}" placeholder="Digite o nome completo">
                @error('nome_completo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 mb-2">
                        CPF *
                    </label>
                    <input type="text" name="cpf" id="cpf" required maxlength="11"
                           class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('cpf') border-red-500 @enderror"
                           value="{{ old('cpf', $socio->cpf) }}" placeholder="Apenas números">
                    @error('cpf')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-2">
                        Data de Nascimento *
                    </label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required
                           class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('data_nascimento') border-red-500 @enderror"
                           value="{{ old('data_nascimento', $socio->data_nascimento->format('Y-m-d')) }}">
                    @error('data_nascimento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    E-mail *
                </label>
                <input type="email" name="email" id="email" required
                       class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                       value="{{ old('email', $socio->email) }}" placeholder="exemplo@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                    Telefone *
                </label>
                <input type="text" name="telefone" id="telefone" required
                       class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('telefone') border-red-500 @enderror"
                       value="{{ old('telefone', $socio->telefone) }}" placeholder="(11) 99999-9999">
                @error('telefone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('socios.show', $socio) }}" class="px-4 py-2 border border-gray-300 text-black rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-150">
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
// Máscara para CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Máscara para telefone
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 7) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    }
    e.target.value = value;
});
</script>
</x-layouts.app>
