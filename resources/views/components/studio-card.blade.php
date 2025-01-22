@props(['studio'])

<div class="rounded-lg shadow-md bg-white p-4">
    <div class="flex items-center space-between gap-4">

        @if ($studio->getFirstMediaUrl('logo'))
            <img src="{{ $studio->getFirstMediaUrl('logo') }}" alt="" class="w-14" />
        @endif

        <div>
            <h2 class="text-xl font-semibold">
                {{ $studio->title }}
            </h2>
        </div>
    </div>
    <p class="text-gray-700 text-lg mt-2">
        {{ Str::limit($studio->preview_text, 100, '...') }}
    </p>
    <ul class="my-4 bg-gray-100 p-4 rounded">
        <li class="mb-2"><strong>Средняя стоимость занятия:</strong>
            {{ number_format($studio->cost_training, 0, '.', ' ') }}
            &#8381;</li>
        <li class="mb-2">
            <strong>Адрес:</strong> {{ $studio->address }}
        </li>
        <li class="mb-2">
            <strong>Теги:</strong> {{ ucwords(str_replace(',', ', ', $studio->tags)) }}
        </li>
    </ul>
    <a href="{{ route('studios.show', $studio) }}"
        class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
        Подробнее
    </a>
</div>
