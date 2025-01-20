<x-layout>
    <x-slot name="title">List Jobs</x-slot>

    <div class="bg-blue-900 flex justify-center py-4 mb-6 rounded">
        <x-search />
    </div>

    @if (request('keywords') || request('location'))
        <div class="mb-6">
            <a href="{{ route('jobs.index') }}"
                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-700 cursor-pointer">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($jobs as $job)
            <x-job-card :job="$job"></x-job-card>

        @empty
            <p>No jobs...</p>
        @endforelse
    </div>
    {{ $jobs->links('pagination::workopia') }}
</x-layout>
