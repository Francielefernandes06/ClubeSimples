
<x-layouts.app :title="__('Carteirinha Bloqueada - Admin')">

<div class="min-h-screen bg-gradient-to-br from-red-50 to-orange-100 py-8">
    <div class="max-w-md mx-auto px-4">
        <!-- Carteirinha Bloqueada -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header da Carteirinha -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-ban text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold">Clube Sistema</h1>
                            <p class="text-red-100 text-sm">Carteirinha Bloqueada</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-red-100">Matrícula</p>
                        <p class="text-lg font-bold">{{ $socio->getNumeroMatricula() }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados do Sócio -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-slash text-red-500 text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $socio->nome_completo }}</h2>
                    <p class="text-red-600 text-sm font-medium">Acesso Bloqueado</p>
                </div>

                <!-- Motivo do Bloqueio -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Carteirinha Temporariamente Bloqueada
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Sua carteirinha está bloqueada devido a mensalidades em atraso há mais de 30 dias.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mensalidades em Atraso -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Mensalidades Pendentes</h3>
                    <div class="space-y-2">
                        @php
                            $mensalidadesAtrasadas = $socio->mensalidades()
                                ->where('status', 'atrasado')
                                ->orderBy('data_vencimento')
                                ->get();
                        @endphp
                        
                        @foreach($mensalidadesAtrasadas as $mensalidade)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Venceu em {{ $mensalidade->data_vencimento->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-red-600">
                                    R$ {{ number_format($mensalidade->valor + $mensalidade->multa, 2, ',', '.') }}
                                </p>
                                @if($mensalidade->multa > 0)
                                    <p class="text-xs text-red-500">
                                        + R$ {{ number_format($mensalidade->multa, 2, ',', '.') }} multa
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @php
                        $totalDevido = $mensalidadesAtrasadas->sum(function($m) {
                            return $m->valor + $m->multa;
                        });
                    @endphp
                    
                    <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-red-800">Total em Atraso:</span>
                            <span class="text-xl font-bold text-red-600">
                                R$ {{ number_format($totalDevido, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Instruções para Regularização -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-2">Como regularizar sua situação:</h3>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-blue-800">
                        <li>Entre em contato com a administração</li>
                        <li>Quite as mensalidades em atraso</li>
                        <li>Aguarde a atualização do sistema (até 24h)</li>
                        <li>Sua carteirinha será desbloqueada automaticamente</li>
                    </ol>
                </div>

                <!-- Ações -->
                <div class="space-y-3">
                    <a href="mailto:financeiro@clube.com?subject=Regularização de Mensalidades - {{ $socio->getNumeroMatricula() }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Entrar em Contato
                    </a>
                    
                    <a href="tel:+5511999999999" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-phone mr-2"></i>
                        Ligar para o Clube
                    </a>
                    
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
                    Consultado em {{ now()->format('d/m/Y H:i') }}
                </p>
                <p class="text-xs text-red-500 mt-1">
                    Regularize sua situação para reativar a carteirinha
                </p>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>

