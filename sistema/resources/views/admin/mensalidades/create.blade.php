
<x-layouts.app :title="__('Nova Mensalidade  - Admin')">

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Dados da Mensalidade</h2>
        </div>

        <form method="POST" action="{{ route('mensalidades.store') }}" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="socio_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Sócio *
                </label>
                <select name="socio_id" id="socio_id" required
                        class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('socio_id') border-red-500 @enderror">
                    <option value="">Selecione um sócio</option>
                    @foreach($socios as $socio)
                        <option value="{{ $socio->id }}" {{ old('socio_id') == $socio->id ? 'selected' : '' }}>
                            {{ $socio->nome_completo }} - {{ $socio->email }}
                        </option>
                    @endforeach
                </select>
                @error('socio_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="mes" class="block text-sm font-medium text-gray-700 mb-2">
                        Mês *
                    </label>
                    <select name="mes" id="mes" required
                            class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('mes') border-red-500 @enderror">
                        <option value="">Selecione</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('mes', date('n')) == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    @error('mes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ano" class="block text-sm font-medium text-gray-700 mb-2">
                        Ano *
                    </label>
                    <select name="ano" id="ano" required
                            class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('ano') border-red-500 @enderror">
                        <option value="">Selecione</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ old('ano', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('ano')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="valor" class="block text-sm font-medium text-gray-700 mb-2">
                        Valor *
                    </label>
                    <input type="number" name="valor" id="valor" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('valor') border-red-500 @enderror"
                           value="{{ old('valor') }}" placeholder="0,00">
                    @error('valor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="data_vencimento" class="block text-sm font-medium text-gray-700 mb-2">
                    Data de Vencimento *
                </label>
                <input type="date" name="data_vencimento" id="data_vencimento" required
                       class="w-full px-3 py-2 border border-gray-300 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('data_vencimento') border-red-500 @enderror"
                       value="{{ old('data_vencimento') }}">
                @error('data_vencimento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('mensalidades.index') }}" class="px-4 py-2 border border-gray-300 text-black rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-150">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Registrar Mensalidade
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-gerar data de vencimento baseada no mês/ano selecionado
document.getElementById('mes').addEventListener('change', updateVencimento);
document.getElementById('ano').addEventListener('change', updateVencimento);

function updateVencimento() {
    const mes = document.getElementById('mes').value;
    const ano = document.getElementById('ano').value;
    
    if (mes && ano) {
        // Definir vencimento para o dia 10 do mês
        const data = new Date(ano, mes - 1, 10);
        const dataFormatada = data.toISOString().split('T')[0];
        document.getElementById('data_vencimento').value = dataFormatada;
    }
}
</script>
</x-layouts.app>
