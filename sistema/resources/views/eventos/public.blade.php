@extends('layouts.app')

@section('title', 'Eventos - Clube Sistema')

@section('content')
<!-- Navigation -->
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
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 font-medium">Início</a>
                <a href="{{ route('eventos.public') }}" class="text-primary-600 hover:text-primary-700 font-medium">Eventos</a>
                <a href="{{ route('login') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                    <i class="fas fa-sign-in-alt mr-1"></i>
                    Admin
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Header -->
<section class="bg-gradient-to-r from-primary-600 to-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Nossos Eventos
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Descubra os próximos eventos e atividades especiais do nosso clube
            </p>
        </div>
    </div>
</section>

<!-- Events Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($eventos->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($eventos as $evento)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    @if($evento->imagem)
                        <img src="{{ Storage::url($evento->imagem) }}" alt="{{ $evento->nome }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $evento->nome }}</h3>
                        
                        @if($evento->descricao)
                            <p class="text-gray-600 mb-4">{{ Str::limit($evento->descricao, 120) }}</p>
                        @endif
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-calendar mr-3 w-4"></i>
                                {{ $evento->data->format('d/m/Y') }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-3 w-4"></i>
                                {{ $evento->horario->format('H:i') }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-3 w-4"></i>
                                {{ $evento->local }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-3 w-4"></i>
                                {{ $evento->participantes_inscritos }}/{{ $evento->limite_participantes }} participantes
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            @if($evento->temVagas())
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    Vagas disponíveis
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-times mr-1"></i>
                                    Esgotado
                                </span>
                            @endif
                            
                            <div class="text-right">
                                <div class="text-xs text-gray-400">
                                    {{ $evento->data->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $eventos->links('pagination::tailwind') }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Nenhum evento encontrado</h3>
                <p class="text-gray-600 mb-8">Não há eventos programados no momento. Volte em breve para conferir as novidades!</p>
                <a href="{{ route('home') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar ao Início
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
            Interessado em participar?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Entre em contato conosco para saber mais sobre como se inscrever nos eventos
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:eventos@clube.com" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-150">
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

<!-- Footer -->
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
                    <li><a href="{{ route('eventos.public') }}" class="text-gray-400 hover:text-white">Eventos</a></li>
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
@endsection
