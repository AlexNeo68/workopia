<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{ url('/') }}">Workopia</a>
        </h1>

        <nav class="hidden md:flex items-center space-x-4">
            <x-nav-link :url="route('jobs.index')" :isActive="request()->is('jobs')">All Jobs</x-nav-link>
            <x-nav-link :url="route('jobs.saved')" :isActive="request()->is('/jobs/saved')">Saved Jobs</x-nav-link>

            <x-nav-link :url="url('/login')" :isActive="request()->is('login')">Login</x-nav-link>
            <x-nav-link :url="url('/register')" :isActive="request()->is('register')">Register</x-nav-link>
            <x-nav-link :url="url('/dashboard')" :isActive="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>

            <x-button-link :url="route('jobs.create')" icon="edit">Create Job</x-button-link>
        </nav>

        <button id="hamburger" class="text-white md:hidden flex items-center">
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="hidden md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2">
        <x-nav-link :mobile="true" :url="route('jobs.index')" :isActive="request()->is('jobs')">All Jobs</x-nav-link>
        <x-nav-link :mobile="true" :url="route('jobs.saved')" :isActive="request()->is('/jobs/saved')">Saved Jobs</x-nav-link>

        <x-nav-link :mobile="true" :url="url('/login')" :isActive="request()->is('login')">Login</x-nav-link>
        <x-nav-link :mobile="true" :url="url('/register')" :isActive="request()->is('register')">Register</x-nav-link>
        <x-nav-link :mobile="true" :url="url('/dashboard')" :isActive="request()->is('dashboard')" icon="gauge">Dashboard</x-nav-link>

        <x-button-link :url="route('jobs.create')" icon="edit" :block="true">Create Job</x-button-link>
    </nav>
</header>
