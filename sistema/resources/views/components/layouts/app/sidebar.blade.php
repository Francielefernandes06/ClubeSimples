<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>
{{--

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body> --}}


<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">Clube Admin</h2>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('socios.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('socios.*') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Sócios
                </a>
                <a href="{{ route('mensalidades.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('mensalidades.*') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : '' }}">
                    <i class="fas fa-credit-card mr-3"></i>
                    Mensalidades
                </a>
                <a href="{{ route('admin.eventos.index') }}"
                    class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.eventos.*') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : '' }}">
                    <i class="fas fa-calendar mr-3"></i>
                    Eventos
                </a>
                <a href="{{ route('admin.carteirinhas.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.carteirinhas.*') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : '' }}">
                    <i class="fas fa-id-card mr-3"></i>
                    Carteirinhas
                </a>
                <a href="{{ route('boletos.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('boletos.*') ? 'bg-primary-50 text-primary-600 border-r-2 border-primary-600' : ''  }}">
                    <i class="fas fa-file-invoice mr-3"></i>
                    <span class="ml-3">Boletos</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600" target="_blank">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            Ver Site
                        </a>
                        <div class="relative">
                            <button class="flex items-center text-gray-700 hover:text-primary-600"
                                onclick="toggleDropdown()">
                                <i class="fas fa-user-circle mr-2 text-xl"></i>
                                {{ auth()->user()->name }}
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="px-8">


                    @if(session('success'))
                        <div
                            class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded alert-auto-hide">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded alert-auto-hide">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function (e) {
            if (!e.target.closest('button')) {
                document.getElementById('userDropdown').classList.add('hidden');
            }
        });

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>


</html>