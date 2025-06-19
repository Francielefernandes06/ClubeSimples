
<x-layouts.app :title="__('Detalhes do Sócio - Admin')">
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header com ações -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $socio->nome_completo }}</h2>
                <div class="flex items-center space-x-4">
                    @if($socio->ativo)
                        @if($socio->isBloqueado())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-ban mr-2"></i>
                                Bloqueado até {{ $socio->bloqueado_ate->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Ativo
                            </span>
                        @endif
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-times-circle mr-2"></i>
                            Inativo
                        </span>
                    @endif
                    
                    @if($socio->temMensalidadeAtrasada())
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Mensalidade em atraso
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('socios.edit', $socio) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('socios.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Informações Pessoais -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user mr-2 text-primary-600"></i>
                        Informações Pessoais
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Nome Completo</dt>
                            <dd class="text-sm text-gray-900">{{ $socio->nome_completo }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">CPF</dt>
                            <dd class="text-sm text-gray-900">
                                {{ substr($socio->cpf, 0, 3) }}.{{ substr($socio->cpf, 3, 3) }}.{{ substr($socio->cpf, 6, 3) }}-{{ substr($socio->cpf, 9, 2) }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">E-mail</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="mailto:{{ $socio->email }}" class="text-primary-600 hover:text-primary-700">
                                    {{ $socio->email }}
                                </a>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Telefone</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="tel:{{ $socio->telefone }}" class="text-primary-600 hover:text-primary-700">
                                    {{ $socio->telefone }}
                                </a>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Data de Nascimento</dt>
                            <dd class="text-sm text-gray-900">
                                {{ $socio->data_nascimento->format('d/m/Y') }}
                                <span class="text-gray-500">({{ $socio->data_nascimento->age }} anos)</span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Cadastrado em</dt>
                            <dd class="text-sm text-gray-900">{{ $socio->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Resumo Financeiro -->
        <div class="space-y-6">
            <!-- Status Financeiro -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-credit-card mr-2 text-primary-600"></i>
                        Status Financeiro
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @php
                       $mensalidadesPendentes = $mensalidades->where('status', 'pendente')->count();
                       $mensalidadesAtrasadas = $mensalidades->where('status', 'atrasado')->count();
                       $mensalidadesPagas = $mensalidades->where('status', 'pago')->count();
                       $totalMultas = $mensalidades->sum('multa');
                        
                    @endphp
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Mensalidades Pagas</span>
                        <span class="text-sm font-medium text-green-600">{{ $mensalidadesPagas }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pendentes</span>
                        <span class="text-sm font-medium text-yellow-600">{{ $mensalidadesPendentes }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Em Atraso</span>
                        <span class="text-sm font-medium text-red-600">{{ $mensalidadesAtrasadas }}</span>
                    </div>
                    
                    @if($totalMultas > 0)
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Total em Multas</span>
                        <span class="text-sm font-medium text-red-600">R$ {{ number_format($totalMultas, 2, ',', '.') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-bolt mr-2 text-primary-600"></i>
                        Ações Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <button class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>
                        Registrar Mensalidade
                    </button>
                    
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-check mr-2"></i>
                        Marcar Pagamento
                    </button>
                    
                    @if($socio->ativo && !$socio->isBloqueado())
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-ban mr-2"></i>
                        Bloquear Sócio
                    </button>
                    @elseif($socio->isBloqueado())
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150 flex items-center justify-center">
                        <i class="fas fa-unlock mr-2"></i>
                        Desbloquear Sócio
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Histórico de Mensalidades -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-history mr-2 text-primary-600"></i>
                Histórico de Mensalidades
            </h3>
            <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150 text-sm">
                <i class="fas fa-plus mr-2"></i>
                Nova Mensalidade
            </button>
        </div>

        @if($mensalidades->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagamento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($mensalidades as $mensalidade)
                    <tr class="hover:bg-gray-50">
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
                                <button class="text-green-600 hover:text-green-900" title="Marcar como pago">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                <button class="text-primary-600 hover:text-primary-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else 
        <div class="p-6 text-center text-gray-500">
            <i class="fas fa-credit-card text-4xl mb-4 text-gray-300"></i>
            <p>Nenhuma mensalidade registrada para este sócio.</p>
            <button class="mt-4 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                <i class="fas fa-plus mr-2"></i>
                Registrar Primeira Mensalidade
            </button>
        </div>
        @endif
    </div>
</div>
</x-layouts.app>

