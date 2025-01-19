@props(['id', 'name', 'label' => null, 'value' => '', 'placeholder' => '', 'required' => false])
<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif

    <textarea {{ $required ? 'required' : '' }} cols="30" rows="7" id="{{ $id }}"
        name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror"
        placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="text-red-500 text-xs">{{ $message }}</div>
    @enderror
</div>
