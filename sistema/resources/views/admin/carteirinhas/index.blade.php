
<x-layouts.app :title="__('Carteirinhas - Admin')">

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Carteirinhas dos Sócios</h2>
        <div class="flex space-x-3">
            <button onclick="gerarTodasCarteirinhas()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                <i class="fas fa-download mr-2"></i>
                Gerar Todas (PDF)
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sócio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matrícula</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Situação</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($socios as $socio)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $socio->nome_completo }}</div>
                        <div class="text-sm text-gray-500">{{ $socio->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $socio->getNumeroMatricula() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($socio->ativo)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>
                                Ativo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-times mr-1"></i>
                                Inativo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($socio->isAdimplente())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Adimplente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Inadimplente
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $socio->getValidadeCarteirinha()->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            @if($socio->ativo && $socio->isAdimplente())
                                <a href="{{ route('carteirinha.show', $socio) }}" target="_blank" class="text-primary-600 hover:text-primary-900" title="Ver Carteirinha">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('carteirinha.pdf', $socio) }}" class="text-green-600 hover:text-green-900" title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            @else
                                <span class="text-gray-400" title="Carteirinha bloqueada">
                                    <i class="fas fa-ban"></i>
                                </span>
                            @endif
                            <button onclick="validarCarteirinha({{ $socio->id }})" class="text-blue-600 hover:text-blue-900" title="Validar QR Code">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        <i class="fas fa-id-card text-4xl mb-4 text-gray-300"></i>
                        <p>Nenhum sócio encontrado.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($socios->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $socios->links() }}
    </div>
    @endif
</div>

<!-- Modal de Validação -->
<div id="validacaoModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Resultado da Validação</h3>
            <div id="validacaoContent"></div>
            <div class="flex justify-end mt-6">
                <button onclick="closeValidacaoModal()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function validarCarteirinha(socioId) {
    const token = btoa(socioId + '_' + Date.now()); // Token simples para demo
    
    fetch(`/carteirinha/validar/${socioId}?token=${token}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('validacaoContent');
            if (data.valid) {
                content.innerHTML = `
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-green-800 mb-2">Carteirinha Válida</h4>
                        <div class="text-left space-y-2">
                            <p><strong>Nome:</strong> ${data.socio.nome}</p>
                            <p><strong>Matrícula:</strong> ${data.socio.matricula}</p>
                            <p><strong>Status:</strong> ${data.socio.status}</p>
                            <p><strong>Válida até:</strong> ${data.socio.validade}</p>
                        </div>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-red-800 mb-2">Carteirinha Inválida</h4>
                        <p class="text-red-600">${data.message}</p>
                    </div>
                `;
            }
            document.getElementById('validacaoModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao validar carteirinha');
        });
}

function closeValidacaoModal() {
    document.getElementById('validacaoModal').classList.add('hidden');
}

function gerarTodasCarteirinhas() {
    if (confirm('Deseja gerar PDF de todas as carteirinhas ativas?')) {
        window.open('/admin/carteirinhas/gerar-todas-pdf', '_blank');
    }
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('validacaoModal');
    if (event.target === modal) {
        closeValidacaoModal();
    }
}
</script>
</x-layouts.app>

