
<x-layouts.app :title="__('Carteirinha Digital - Admin')">
<div class="min-h-screen bg-gradient-to-br from-primary-50 to-blue-100 py-8">
    <div class="max-w-md mx-auto px-4">
        <!-- Carteirinha Digital -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header da Carteirinha -->
            <div class="bg-gradient-to-r from-primary-600 to-blue-700 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-users text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold">Clube Sistema</h1>
                            <p class="text-blue-100 text-sm">Carteirinha Digital</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-blue-100">Matrícula</p>
                        <p class="text-lg font-bold">{{ $socio->getNumeroMatricula() }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados do Sócio -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $socio->nome_completo }}</h2>
                    <p class="text-gray-600 text-sm">Sócio Ativo</p>
                </div>

                <!-- Informações -->
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 text-sm">Data de Nascimento:</span>
                        <span class="font-medium text-gray-900">{{ $socio->data_nascimento->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 text-sm">CPF:</span>
                        <span class="font-medium text-gray-900">
                            {{ substr($socio->cpf, 0, 3) }}.{{ substr($socio->cpf, 3, 3) }}.{{ substr($socio->cpf, 6, 3) }}-{{ substr($socio->cpf, 9, 2) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600 text-sm">Válida até:</span>
                        <span class="font-medium text-green-600">{{ $socio->getValidadeCarteirinha()->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 text-sm">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Adimplente
                        </span>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="text-center mb-6">
                    <p class="text-gray-600 text-sm mb-3">QR Code para Validação</p>
                    <div class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                        {!! $qrCode !!}
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Apresente este código para validação</p>
                </div>

                <!-- Ações -->
                <div class="space-y-3">
                    <a href="{{ route('carteirinha.pdf', $socio) }}" 
                       class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>
                        Baixar PDF
                    </a>
                    
                    <button onclick="compartilhar()" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-share mr-2"></i>
                        Compartilhar
                    </button>
                    
                    <a href="{{ route('home') }}" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar ao Site
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center">
                <p class="text-xs text-gray-500">
                    Emitida em {{ now()->format('d/m/Y H:i') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Esta carteirinha é válida apenas para sócios adimplentes
                </p>
            </div>
        </div>

        <!-- Informações Adicionais -->
        <div class="mt-6 bg-white rounded-lg shadow p-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-info-circle text-primary-600 mr-2"></i>
                Como usar sua carteirinha
            </h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                    Apresente o QR Code na entrada do clube
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                    Baixe o PDF para ter acesso offline
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                    Mantenha suas mensalidades em dia
                </li>
                <li class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2 mt-0.5 text-xs"></i>
                    Carteirinha bloqueada automaticamente se inadimplente
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
function compartilhar() {
    if (navigator.share) {
        navigator.share({
            title: 'Minha Carteirinha Digital - Clube Sistema',
            text: 'Confira minha carteirinha digital do Clube Sistema',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copiado para a área de transferência!');
        });
    }
}

// Adicionar à tela inicial (PWA)
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    deferredPrompt = e;
    // Mostrar botão de instalação se desejar
});
</script>
</x-layouts.app>

