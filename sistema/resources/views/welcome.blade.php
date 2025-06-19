<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Clube Sistema')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#eff6ff',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                            }
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="">
       
        <nav class="bg-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <div class="h-8 w-8 bg-primary-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <span class="text-xl font-bold text-gray-800">Clube Sistema</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-8">
                        <a href="" class="text-primary-600 hover:text-primary-700 font-medium">Início</a>
                        <a href="" class="text-gray-700 hover:text-primary-600 font-medium">Eventos</a>
                        <a href="{{ route('login') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Admin
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <section class="bg-gradient-to-br from-primary-600 to-blue-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Bem-vindo ao Nosso Clube
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                        Um espaço de convivência, eventos e momentos especiais para toda nossa comunidade
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-150">
                            <i class="fas fa-calendar mr-2"></i>
                            Ver Eventos
                        </a>
                        <a href="#sobre" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition duration-150">
                            <i class="fas fa-info-circle mr-2"></i>
                            Saiba Mais
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="sobre" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Por que fazer parte?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Oferecemos uma experiência completa com benefícios exclusivos para nossos membros
                    </p>
                </div>
        
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calendar-alt text-primary-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Eventos Exclusivos</h3>
                        <p class="text-gray-600">Participe de eventos únicos e atividades especiais organizadas especialmente para nossos membros.</p>
                    </div>
        
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-primary-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Comunidade</h3>
                        <p class="text-gray-600">Faça parte de uma comunidade acolhedora e conecte-se com pessoas que compartilham seus interesses.</p>
                    </div>
        
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-primary-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Benefícios</h3>
                        <p class="text-gray-600">Aproveite vantagens exclusivas, descontos especiais e acesso prioritário a todas as atividades.</p>
                    </div>
                </div>
            </div>
        </section>

        @if($eventosDestaque->count() > 0)
            <section class="py-20 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Próximos Eventos
                        </h2>
                        <p class="text-xl text-gray-600">
                            Não perca os eventos que estão por vir
                        </p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach($eventosDestaque as $evento)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                                @if($evento->imagem)
                                    <img src="{{ Storage::url($evento->imagem) }}" alt="{{ $evento->nome }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-white text-4xl"></i>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $evento->nome }}</h3>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($evento->descricao, 100) }}</p>

                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ $evento->data->format('d/m/Y') }}
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ $evento->horario->format('H:i') }}
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $evento->local }}
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">
                                            {{ $evento->participantes_inscritos }}/{{ $evento->limite_participantes }} inscritos
                                        </span>
                                        @if($evento->temVagas)
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Vagas
                                                disponíveis</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Esgotado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href=""
                            class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-150">
                            Ver Todos os Eventos
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <section class="py-20 bg-primary-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Pronto para fazer parte?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Entre em contato conosco e descubra como se tornar um membro do nosso clube
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:contato@clube.com" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-150">
                        <i class="fas fa-envelope mr-2"></i>
                        Entrar em Contato
                    </a>
                    <a href="tel:+5511999999999" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition duration-150">
                        <i class="fas fa-phone mr-2"></i>
                        (11) 99999-9999
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="h-8 w-8 bg-primary-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <span class="text-xl font-bold">Clube Sistema</span>
                        </div>
                        <p class="text-gray-400">
                            Um espaço de convivência e eventos para toda nossa comunidade.
                        </p>
                    </div>
        
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Início</a></li>
                            <li><a href="" class="text-gray-400 hover:text-white">Eventos</a></li>
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Admin</a></li>
                        </ul>
                    </div>
        
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contato</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><i class="fas fa-envelope mr-2"></i> contato@clube.com</li>
                            <li><i class="fas fa-phone mr-2"></i> (11) 99999-9999</li>
                            <li><i class="fas fa-map-marker-alt mr-2"></i> São Paulo, SP</li>
                        </ul>
                    </div>
        
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Redes Sociais</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white text-xl">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white text-xl">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white text-xl">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
        
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Clube Sistema. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>



    </body>
</html>
