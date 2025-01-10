<x-layout>
    <x-slot name="title">List Jobs</x-slot>
    @forelse ($jobs as $job)
        <li>
            <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }} ({{ $job->description }})</a>
        </li>
    @empty
        <li>No jobs...</li>
    @endforelse
</x-layout>
