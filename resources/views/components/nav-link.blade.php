@props([
    'url' => '/',
    'isActive' => false,
    'mobile' => false,
    'icon' => null,
])


<a href="{{ $url }}"
    class="{{ $mobile ? 'block px-4 py-2 hover:bg-blue-700' : 'text-white hover:underline py-2' }}{{ $isActive ? 'text-yellow-400 font-bold' : '' }}">
    @if ($icon)
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>
