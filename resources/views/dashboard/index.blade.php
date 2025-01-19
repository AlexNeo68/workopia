<x-layout>
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>


    <div class="flex flex-col w-full md:flex-row gap-4">
        <div class="shadow rounded-md p-8">
            <h3 class="text-2xl font-bold mb-4">Profile</h3>
            @if ($user->avatar)
                <div class="mb-2 flex justify-center">
                    <img src="{{ $user->avatar }}" class="inline-block w-28 h-28 rounded-full object-cover"
                        alt="" />
                </div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-inputs.text name="name" label="Name" value="{{ $user->name }}"></x-inputs.text>
                <x-inputs.text name="email" type="email" label="Email" value="{{ $user->email }}"></x-inputs.text>

                <x-inputs.file name="avatar" label="Upload avatar" id="avatar" />

                <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded w-full">Save</button>
            </form>
        </div>
        <div class="shadow rounded-md p-8">
            <h3 class="text-2xl font-bold mb-4">Job Listing</h3>
            @forelse ($jobs as $job)
                <div class="mb-4">
                    <div class="flex mb-2 justify-between">
                        <div>
                            <a class="text-blue-500" href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                            <p class="text-sm">{{ Str::limit($job->description, 50, '...') }}</p>
                        </div>
                        <div>
                            <div class="flex space-x-3 ml-4">
                                <a href="{{ route('jobs.edit', $job) }}"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                                <!-- Delete Form -->
                                <form method="POST" action="{{ route('jobs.destroy', $job) }}?from=dashboard"
                                    onsubmit="return confirm('Are you shure that want to delete this job?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                        Delete
                                    </button>
                                </form>
                                <!-- End Delete Form -->
                            </div>

                        </div>
                    </div>
                    @if ($job->aplicants()->count())
                        <h3 class="font-semibold mb-2">Aplicants</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($job->aplicants as $aplicant)
                                <div class="text-xs shadow p-2 rounded relative">
                                    <p class="text-gray-600">
                                        <span class="font-bold">Name:</span>
                                        {{ $aplicant->full_name }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-bold">Phone:</span>
                                        {{ $aplicant->contact_phone }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-bold">Email:</span>
                                        {{ $aplicant->contact_email }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-bold">Location:</span>
                                        {{ $aplicant->location }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-bold">Resume:</span>
                                        <a download class="text-blue-500 hover:text-blue-600"
                                            href="{{ $aplicant->resume_path }}">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </p>
                                    <form method="POST" class=" absolute right-1 top-1"
                                        onsubmit="confirm('Are you shure to delet this application?')"
                                        action="{{ route('aplicant.destroy', $aplicant) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 cursor-pointer hover:text-red-600"><i
                                                class="fas fa-trash"></i></button>
                                    </form>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p>Jobs not found</p>
            @endforelse
        </div>
    </div>



</x-layout>
