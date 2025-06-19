
<x-layouts.app :title="__('Inadimplentes  - Admin')">

<div class="mb-6">
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    Atenção: Sócios com Mensalidades em Atraso
                </h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Esta lista mostra todos os sócios que possuem mensalidades vencidas há mais de 10 dias.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($inadimplentes->count() > 0)
<div class="space-y-6">
    @foreach($inadimplentes as $socio)
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $socio->nome_completo }}</h3>
                    <div class="flex items-center space-x-4 mt-1">
                        <span class="text-sm text-gray-600">{{ $socio->email }}</span>
                        <span class="text-sm text-gray-600">{{ $socio->telefone }}</span>
                        @if($socio->isBloqueado())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-ban mr-1"></i>
                                Bloqueado
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('socios.show', $socio) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        Ver Perfil
                    </a>
                    <button class="text-green-600 hover:text-green-700 text-sm font-medium">
                        Contatar
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <h4 class="text-sm font-medium text-gray-900 mb-4">Mensalidades em Atraso</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vencimento</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dias em Atraso</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Multa</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($socio->mensalidades as $mensalidade)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                R$ {{ number_format($mensalidade->valor, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ $mensalidade->data_vencimento->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm">
                                @php
                                    $diasAtraso = now()->diffInDays($mensalidade->data_vencimento);
                                @endphp
                                <span class="text-red-600 font-medium">{{ $diasAtraso }} dias</span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                @if($mensalidade->multa > 0)
                                    <span class="text-red-600 font-medium">
                                        R$ {{ number_format($mensalidade->multa, 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <button onclick="openPagamentoModal({{ $mensalidade->id }})" 
                                        class="text-green-600 hover:text-green-700 font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    Pagar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $totalDevido = $socio->mensalidades->sum(function($m) {
                    return $m->valor + $m->multa;
                });
            @endphp
            
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Total em Atraso:</span>
                    <span class="text-lg font-bold text-red-600">
                        R$ {{ number_format($totalDevido, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                               value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closePagamentoModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
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

@else
<div class="bg-white rounded-lg shadow p-12 text-center">
    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-check-circle text-green-600 text-3xl"></i>
    </div>
    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Parabéns!</h3>
    <p class="text-gray-600 mb-8">Não há sócios inadimplentes no momento. Todos estão em dia com suas mensalidades.</p>
    <a href="{{ route('mensalidades.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition duration-150">
        <i class="fas fa-arrow-left mr-2"></i>
        Voltar às Mensalidades
    </a>
</div>
@endif

<script>
function openPagamentoModal(mensalidadeId) {
    const form = document.getElementById('pagamentoForm');
    form.action = `/mensalidades/${mensalidadeId}/marcar-pago`;
    document.getElementById('pagamentoModal').classList.remove('hidden');
}

function closePagamentoModal() {
    document.getElementById('pagamentoModal').classList.add('hidden');
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('pagamentoModal');
    if (event.target === modal) {
        closePagamentoModal();
    }
}
</script>
</x-layouts.app>