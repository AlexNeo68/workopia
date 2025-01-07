<x-layout>
    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <input type="text" name="title" value="{{ old('title') }}" placeholder="Type title">
        <input type="text" name="description" value="{{ old('description') }}" placeholder="Type description">
        <button type="submit">Save</button>
    </form>
</x-layout>
