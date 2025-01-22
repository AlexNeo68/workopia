<x-layout>
    <h2 class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">
        Новые студии
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($studios as $studio)
            <x-studio-card :studio="$studio"></x-studio-card>

        @empty
            <p>Нет студий...</p>
        @endforelse
    </div>
    <a href="{{ route('studios.index') }}" class="block text-md text-center">
        <i class="fa fa-arrow-alt-circle-right"></i> Показать все студии
    </a>

    <x-bottom-banner />
</x-layout>
