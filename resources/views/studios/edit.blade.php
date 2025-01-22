<x-layout>
    <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
        <h2 class="text-4xl text-center font-bold mb-4">
            Update Job Listing - "{{ $job->title }}"
        </h2>
        <x-job.job-form :job="$job" do="update" />
    </div>
</x-layout>
