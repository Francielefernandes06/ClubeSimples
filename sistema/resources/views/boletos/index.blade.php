
<x-layouts.app :title="__('Boletos - Admin')">
<!-- Estatísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
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
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Enviados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['enviados'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pagos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pagos'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Vencidos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['vencidos'] }}</p>
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
                    <select name="status" class="border border-gray-300 rounded-lg text-black px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Status</option>
                        <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="enviado" {{ request('status') === 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="pago" {{ request('status') === 'pago' ? 'selected' : '' }}>Pago</option>
                        <option value="vencido" {{ request('status') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                </div>

                <div>
                    <select name="mes" class="border border-gray-300 rounded-lg text-black px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Meses</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <select name="ano" class="border border-gray-300 rounded-lg text-black px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos os Anos</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('ano') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-search mr-2"></i>
                    Filtrar
                </button>

                @if(request()->hasAny(['status', 'mes', 'ano']))
                    <a href="{{ route('boletos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Limpar
                    </a>
                @endif
            </form>

            <!-- Ações -->
            <div class="flex space-x-3">
                <button onclick="openGerarLoteModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-150">
                    <i class="fas fa-layer-group mr-2"></i>
                    Gerar Lote
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Lista de Boletos -->
<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sócio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($boletos as $boleto)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $boleto->numero_boleto }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $boleto->created_at->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $boleto->mensalidade->socio->nome_completo }}</div>
                        <div class="text-sm text-gray-500">{{ $boleto->mensalidade->socio->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ str_pad($boleto->mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $boleto->mensalidade->ano }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ {{ number_format($boleto->valor_total, 2, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $boleto->data_vencimento->format('d/m/Y') }}
                        @if($boleto->isVencido())
                            <div class="text-xs text-red-600">
                                {{ $boleto->data_vencimento->diffForHumans() }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($boleto->status)
                            @case('pago')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Pago
                                </span>
                                @break
                            @case('enviado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-paper-plane mr-1"></i>
                                    Enviado
                                </span>
                                @if($boleto->enviado_em)
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $boleto->enviado_em->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                                @break
                            @case('vencido')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Vencido
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
                            <a href="{{ route('boletos.download', $boleto) }}" class="text-blue-600 hover:text-blue-900" title="Download PDF">
                                <i class="fas fa-download"></i>
                            </a>
                            
                            @if($boleto->podeReenviar())
                            <form method="POST" action="{{ route('boletos.enviar-email', $boleto) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900" title="Enviar por email">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </form>
                            @endif

                            @if($boleto->status !== 'pago')
                            <form method="POST" action="{{ route('boletos.marcar-pago', $boleto) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900" title="Marcar como pago" onclick="return confirm('Confirmar pagamento deste boleto?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif

                            <form method="POST" action="{{ route('boletos.destroy', $boleto) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este boleto?')">
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
                        <i class="fas fa-file-invoice text-4xl mb-4 text-gray-300"></i>
                        <p>Nenhum boleto encontrado.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($boletos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $boletos->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Modal Gerar Lote -->
<div id="gerarLoteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Gerar Boletos em Lote</h3>
            <form method="POST" action="{{ route('boletos.gerar-lote') }}">
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
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="enviar_email" value="1" id="enviar_email" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="enviar_email" class="ml-2 block text-sm text-gray-900">
                            Enviar por email automaticamente
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeGerarLoteModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-black text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                        Gerar Boletos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openGerarLoteModal() {
    document.getElementById('gerarLoteModal').classList.remove('hidden');
}

function closeGerarLoteModal() {
    document.getElementById('gerarLoteModal').classList.add('hidden');
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('gerarLoteModal');
    if (event.target === modal) {
        closeGerarLoteModal();
    }
}
</script>
</x-layouts.app>
