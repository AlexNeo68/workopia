<x-layout>
    <h2 class="text-3xl">Bookmarked Jobs</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
        @forelse ($bookmarks as $bookmark)
            <x-job-card :job="$bookmark"></x-job-card>
        @empty
            <p>Jobs not saved</p>
        @endforelse
    </div>

</x-layout>
