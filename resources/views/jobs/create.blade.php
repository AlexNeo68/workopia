<x-layout>
    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <div>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Type title">
            @error('title')
                <div class="text-xs text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <input type="text" name="description" value="{{ old('description') }}" placeholder="Type description">
            @error('description')
                <div class="text-xs text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Save</button>
    </form>
</x-layout>
