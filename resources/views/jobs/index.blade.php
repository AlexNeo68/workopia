<x-layout>
    <x-slot name="title">List Jobs</x-slot>
    @forelse ($jobs as $job)
        <li>
            <a href="{{ route('jobs.show', $loop->iteration) }}">{{ $loop->iteration }} - {{ $job }}</a>
        </li>
    @empty
        <li>No jobs...</li>
    @endforelse
</x-layout>
