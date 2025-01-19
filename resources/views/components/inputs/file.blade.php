@props(['id', 'name', 'label' => null, 'value' => null, 'required' => false])
<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif

    @if ($value && ($name = 'company_logo'))
        <p>
            <img src="/storage/{{ $value }}" alt="">
        </p>
    @endif

    <input {{ $required ? 'required' : '' }} id="{{ $id }}" type="file" name="{{ $name }}"
        class="w-full px-4 py-2 border rounded focus:outline-none @error($name) border-red-500 @enderror" />
    @error($name)
        <div class="text-red-500 text-xs">{{ $message }}</div>
    @enderror
</div>
