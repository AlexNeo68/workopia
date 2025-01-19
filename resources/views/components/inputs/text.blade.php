@props(['id', 'type' => 'text', 'name', 'label' => null, 'value' => '', 'placeholder' => '', 'required' => false])
<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif

    <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" />
    @error($name)
        <div class="text-red-500 text-xs">{{ $message }}</div>
    @enderror
</div>
