@props(['type', 'bg' => 'bg-green-500', 'message', 'timeout' => '5000'])
@if (session()->has($type))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, {{ $timeout }})"
        class="p-4 mb-4 rounded text-sm text-white {{ $bg }}">
        {{ $message }}
    </div>
@endif
