<x-layouts.app :title="__('Dashboard')">


    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Sócios -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total de Sócios</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSocios }}</p>
                    <p class="text-xs text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $sociosAtivos }} ativos
                    </p>
                </div>
            </div>
        </div>

        <!-- Mensalidades Pagas -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mensalidades Pagas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mensalidadesStats['pagas'] }}</p>
                    <p class="text-xs text-gray-500">
                        {{ round(($mensalidadesStats['pagas'] / max($mensalidadesStats['total'], 1)) * 100, 1) }}% do
                        total
                    </p>
                </div>
            </div>
        </div>

        <!-- Mensalidades Atrasadas -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Em Atraso</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mensalidadesStats['atrasadas'] }}</p>
                    <p class="text-xs text-red-600">
                        <i class="fas fa-arrow-down mr-1"></i>
                        Requer atenção
                    </p>
                </div>
            </div>
        </div>

        <!-- Total de Eventos -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total de Eventos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEventos }}</p>
                    <p class="text-xs text-purple-600">
                        {{ $proximosEventos->count() }} próximos
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Gráfico de Receita Mensal -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-primary-600"></i>
                    Receita Mensal ({{ date('Y') }})
                </h3>
            </div>
            <div class="p-6">
                <canvas id="receitaChart" height="120"></canvas>
            </div>
        </div>

        <!-- Gráfico de Mensalidades por Status -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-primary-600"></i>
                    Mensalidades por Status
                </h3>
            </div>
            <div class="p-6">
                <canvas id="statusChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Próximos Eventos -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-alt mr-2 text-primary-600"></i>
                    Próximos Eventos
                </h3>
                <a href="{{ route('admin.eventos.index') }}"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Ver todos
                </a>
            </div>
            <div class="p-6">
                @if($proximosEventos->count() > 0)
                    <div class="space-y-4">
                        @foreach($proximosEventos as $evento)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar text-primary-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $evento->nome }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $evento->data->format('d/m/Y') }} às {{ $evento->horario->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $evento->participantes_inscritos }}/{{ $evento->limite_participantes }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-gray-300 text-3xl mb-3"></i>
                        <p class="text-gray-500 text-sm">Nenhum evento programado</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mensalidades Vencendo -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-clock mr-2 text-yellow-600"></i>
                    Vencendo em 7 dias
                </h3>
                <a href="{{ route('mensalidades.index') }}"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Ver todas
                </a>
            </div>
            <div class="p-6">
                @if($mensalidadesVencendo->count() > 0)
                    <div class="space-y-4">
                        @foreach($mensalidadesVencendo as $mensalidade)
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $mensalidade->socio->nome_completo }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }} -
                                        Vence {{ $mensalidade->data_vencimento->format('d/m') }}
                                    </p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    R$ {{ number_format($mensalidade->valor, 2, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-green-300 text-3xl mb-3"></i>
                        <p class="text-gray-500 text-sm">Nenhuma mensalidade vencendo</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Inadimplentes Críticos -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                    Inadimplentes Críticos
                </h3>
                <a href="{{ route('mensalidades.inadimplentes') }}"
                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Ver todos
                </a>
            </div>
            <div class="p-6">
                @if($inadimplentes->count() > 0)
                    <div class="space-y-4">
                        @foreach($inadimplentes as $socio)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $socio->nome_completo }}</p>
                                            <p class="text-xs text-red-600">
                                                {{ $socio->mensalidades->count() }} mensalidade(s) em atraso
                                            </p>
                                        </div>
                                        <div class="text-sm font-medium text-red-600">
                                            R$
                                            {{ number_format($socio->mensalidades->sum(function ($m) {
                            return $m->valor + $m->multa; }), 2, ',', '.') }}
                                        </div>
                                    </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-thumbs-up text-green-300 text-3xl mb-3"></i>
                        <p class="text-gray-500 text-sm">Nenhum inadimplente crítico</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Gráfico de Crescimento de Sócios -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chart-area mr-2 text-primary-600"></i>
                Crescimento de Sócios (Últimos 12 meses)
            </h3>
        </div>
        <div class="p-6">
            <canvas id="crescimentoChart" height="100"></canvas>
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
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('socios.create') }}"
                    class="flex items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <div class="text-center">
                        <i class="fas fa-user-plus text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-blue-800">Novo Sócio</p>
                    </div>
                </a>

                <a href="{{ route('mensalidades.create') }}"
                    class="flex items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                    <div class="text-center">
                        <i class="fas fa-credit-card text-green-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-green-800">Nova Mensalidade</p>
                    </div>
                </a>

                <a href="{{ route('admin.eventos.create') }}"
                    class="flex items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <div class="text-center">
                        <i class="fas fa-calendar-plus text-purple-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-purple-800">Novo Evento</p>
                    </div>
                </a>

                <button onclick="openGerarModal()"
                    class="flex items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-200">
                    <div class="text-center">
                        <i class="fas fa-calendar-check text-yellow-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-yellow-800">Gerar Mensalidades</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

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
                                <select name="mes" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                                <select name="ano" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    @for($i = date('Y'); $i <= date('Y') + 1; $i++)
                                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
                            <input type="number" name="valor" step="0.01" min="0" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="0,00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dia do Vencimento</label>
                            <input type="number" name="dia_vencimento" min="1" max="31" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                value="10">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeGerarModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                            Gerar Mensalidades
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const receitaCtx = document.getElementById('receitaChart').getContext('2d');
        new Chart(receitaCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Receita (R$)',
                    data: @json($receitaCompleta),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Status das Mensalidades
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pagas', 'Pendentes', 'Atrasadas'],
                datasets: [{
                    data: [
                    {{ $mensalidadesStats['pagas'] }},
                    {{ $mensalidadesStats['pendentes'] }},
                        {{ $mensalidadesStats['atrasadas'] }}
                    ],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const crescimentoCtx = document.getElementById('crescimentoChart').getContext('2d');
        new Chart(crescimentoCtx, {
            type: 'bar',
            data: {
                labels: @json(array_column($crescimentoSocios, 'mes')),
                datasets: [{
                    label: 'Novos Sócios',
                    data: @json(array_column($crescimentoSocios, 'total')),
                    backgroundColor: 'rgba(147, 51, 234, 0.8)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        function openGerarModal() {
            document.getElementById('gerarModal').classList.remove('hidden');
        }

        function closeGerarModal() {
            document.getElementById('gerarModal').classList.add('hidden');
        }

        window.onclick = function (event) {
            const modal = document.getElementById('gerarModal');
            if (event.target === modal) {
                closeGerarModal();
            }
        }
    </script>



</x-layouts.app>