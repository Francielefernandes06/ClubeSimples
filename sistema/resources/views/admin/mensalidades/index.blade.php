
<x-layouts.app :title="__('Mensalidades - Admin')">

<!-- Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-credit-card text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pagas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pagas'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pendentes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pendentes'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Atrasadas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['atrasadas'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros e Ações -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <!-- Filtros -->
            <form method="GET" class="flex flex-wrap gap-4">
                <div>
                    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-black text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Status</option>
                        <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="pago" {{ request('status') === 'pago' ? 'selected' : '' }}>Pago</option>
                        <option value="atrasado" {{ request('status') === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                    </select>
                </div>

                <div>
                    <select name="mes" class="border border-gray-300 rounded-lg px-3 py-2 text-black text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Meses</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <select name="ano" class="border border-gray-300 rounded-lg px-3 py-2 text-black text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Anos</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('ano') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <input type="text" name="socio" placeholder="Nome do sócio..." 
                           class="border border-gray-300 rounded-lg px-3 py-2 text-black text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           value="{{ request('socio') }}">
                </div>

                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-search mr-2"></i>
                    Filtrar
                </button>

                @if(request()->hasAny(['status', 'mes', 'ano', 'socio']))
                    <a href="{{ route('mensalidades.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Limpar
                    </a>
                @endif
            </form>

            <!-- Ações -->
            <div class="flex space-x-3">
                <a href="{{ route('mensalidades.inadimplentes') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Inadimplentes
                </a>
                <button onclick="openGerarModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Gerar Mês
                </button>
                <a href="{{ route('mensalidades.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Nova Mensalidade
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Mensalidades -->
<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sócio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagamento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mensalidades as $mensalidade)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $mensalidade->socio->nome_completo }}</div>
                        <div class="text-sm text-gray-500">{{ $mensalidade->socio->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ {{ number_format($mensalidade->valor, 2, ',', '.') }}</div>
                        @if($mensalidade->multa > 0)
                            <div class="text-xs text-red-600">+ R$ {{ number_format($mensalidade->multa, 2, ',', '.') }} (multa)</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $mensalidade->data_vencimento->format('d/m/Y') }}
                        @if($mensalidade->data_vencimento->isPast() && $mensalidade->status !== 'pago')
                            <div class="text-xs text-red-600">
                                {{ $mensalidade->data_vencimento->diffForHumans() }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $mensalidade->data_pagamento ? $mensalidade->data_pagamento->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($mensalidade->status)
                            @case('pago')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Pago
                                </span>
                                @break
                            @case('atrasado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Atrasado
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pendente
                                </span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            @if($mensalidade->status !== 'pago')
                            <button onclick="openPagamentoModal({{ $mensalidade->id }})" class="text-green-600 hover:text-green-900" title="Marcar como pago">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                            <a href="{{ route('mensalidades.edit', $mensalidade) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('mensalidades.destroy', $mensalidade) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta mensalidade?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        <i class="fas fa-credit-card text-4xl mb-4 text-gray-300"></i>
                        <p>Nenhuma mensalidade encontrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mensalidades->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $mensalidades->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Modal Gerar Mensalidades -->
<div id="gerarModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Gerar Mensalidades do Mês</h3>
            <form method="POST" action="{{ route('mensalidades.gerar-mes') }}">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                            <select name="mes" required class="w-full border border-gray-300 rounded-lg text-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                            <select name="ano" required class="w-full border border-gray-300 rounded-lg text-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @for($i = date('Y'); $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                        <input type="number" name="valor" step="0.01" min="0" required 
                               class="w-full border border-gray-300 rounded-lg text-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               placeholder="0,00">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dia do Vencimento</label>
                        <input type="number" name="dia_vencimento" min="1" max="31" required 
                               class="w-full border border-gray-300 rounded-lg text-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               value="10">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeGerarModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-black text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                        Gerar Mensalidades
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Marcar Pagamento -->
<div id="pagamentoModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Registrar Pagamento</h3>
            <form id="pagamentoForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Data do Pagamento</label>
                        <input type="date" name="data_pagamento" required 
                               class="w-full border border-gray-300 rounded-lg text-black px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closePagamentoModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-black text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Confirmar Pagamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openGerarModal() {
    document.getElementById('gerarModal').classList.remove('hidden');
}

function closeGerarModal() {
    document.getElementById('gerarModal').classList.add('hidden');
}

function openPagamentoModal(mensalidadeId) {
    const form = document.getElementById('pagamentoForm');
    form.action = `/mensalidades/${mensalidadeId}/marcar-pago`;
    document.getElementById('pagamentoModal').classList.remove('hidden');
}

function closePagamentoModal() {
    document.getElementById('pagamentoModal').classList.add('hidden');
}

// Fechar modais ao clicar fora
window.onclick = function(event) {
    const gerarModal = document.getElementById('gerarModal');
    const pagamentoModal = document.getElementById('pagamentoModal');
    
    if (event.target === gerarModal) {
        closeGerarModal();
    }
    if (event.target === pagamentoModal) {
        closePagamentoModal();
    }
}
</script>
</x-layouts.app>