<button {{ $attributes->merge(['class' => 'bg-indigo-500 hover:bg-indigo-600 text-white text-sm py-2 px-4 rounded']) }}>
    {{ $slot }}
</button>
