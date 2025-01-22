<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{ url('/') }}">ПравИло ВСЕМ</a>
        </h1>

        <nav class="hidden md:flex items-center space-x-4">
            <x-nav-link :url="route('studios.index')" :isActive="request()->is('studios')">Все студии</x-nav-link>
            <x-nav-link :url="route('studios.index')" :isActive="request()->is('studios')">О ПравИло</x-nav-link>
            <x-nav-link :url="route('studios.index')" :isActive="request()->is('studios')">Статьи</x-nav-link>
            <x-nav-link :url="route('studios.index')" :isActive="request()->is('studios')">Новости</x-nav-link>
            <x-nav-link :url="route('studios.index')" :isActive="request()->is('studios')">Отзывы</x-nav-link>

            @guest
                <x-nav-link :url="url('/login')" :isActive="request()->is('login')"> <i class="fas fa-lock"></i> <span>Вход</span></x-nav-link>

                <x-nav-link :url="url('/register')" :isActive="request()->is('register')">Регистрация</x-nav-link>
            @endguest

            @auth
                <x-nav-link :url="route('studios.bookmarked')" :isActive="request()->is('/studios/saved')">Saved Studios</x-nav-link>

                <x-nav-link :url="url('/dashboard')" :isActive="request()->is('dashboard')">
                    @if (Auth::user()->avatar)
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            alt="">
                    @else
                        <img class="w-12 h-12 rounded-full" src="{{ asset('storage/avatars/default-avatar.png') }}"
                            alt="">
                    @endif
                </x-nav-link>

                <x-logout-button />

                <x-button-link :url="route('studios.create')" icon="edit">Create Job</x-button-link>
            @endauth


        </nav>

        <button id="hamburger" @click="open = !open" class="text-white md:hidden flex items-center">
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <!-- Mobile Menu -->
    <nav x-show="open" @click.away="open = false" id="mobile-menu"
        class="hidden md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2">
        <x-nav-link :mobile="true" :url="route('studios.index')" :isActive="request()->is('studios')">All Studios</x-nav-link>
        <x-nav-link :mobile="true" :url="route('jobs.saved')" :isActive="request()->is('/studios/saved')">Saved Studios</x-nav-link>

        <x-nav-link :mobile="true" :url="url('/login')" :isActive="request()->is('login')">Login</x-nav-link>
        <x-nav-link :mobile="true" :url="url('/register')" :isActive="request()->is('register')">Register</x-nav-link>
        <x-nav-link :mobile="true" :url="url('/dashboard')" :isActive="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>

        <x-button-link :url="route('studios.create')" icon="edit" :block="true">Create Job</x-button-link>
    </nav>
</header>
