<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Job Details Column -->
        <section class="md:col-span-3">
            <div class="rounded-lg shadow-md bg-white p-3">
                <div class="flex justify-between items-center">
                    <a class="block p-4 text-blue-700" href="{{ route('jobs.index') }}">
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Back To Listings
                    </a>

                    @can('update', $job)
                        <div class="flex space-x-3 ml-4">
                            <a href="{{ route('jobs.edit', $job) }}"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                            <!-- Delete Form -->
                            <form method="POST" action="{{ route('jobs.destroy', $job) }}"
                                onsubmit="return confirm('Are you shure that want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                            <!-- End Delete Form -->
                        </div>
                    @endcan


                </div>


                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        {{ $job->title }}
                    </h2>
                    <p class="text-gray-700 text-lg mt-2">{{ $job->description }}</p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Job Type:</strong> {{ $job->job_type }}
                        </li>
                        <li class="mb-2">
                            <strong>Remote:</strong> {{ $job->remote ? 'Yes' : 'No' }}
                        </li>
                        <li class="mb-2">
                            <strong>Salary:</strong> ${{ number_format($job->salary) }}
                        </li>
                        <li class="mb-2">
                            <strong>Site Location:</strong> {{ $job->city }}, {{ $job->state }}
                        </li>
                        <li class="mb-2">
                            <strong>Tags:</strong>{{ ucwords(str_replace(',', ', ', $job->tags)) }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="container mx-auto p-4">
                <h2 class="text-xl font-semibold mb-4">Job Details</h2>
                <div class="rounded-lg shadow-md bg-white p-4">
                    <h3 class="text-lg font-semibold mb-2 text-blue-500">
                        Job Requirements
                    </h3>
                    <p>
                        {{ $job->requirements }}
                    </p>
                    <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">
                        Benefits
                    </h3>
                    <p>
                        {{ $job->benefits }}
                    </p>
                </div>

                @auth
                    <p class="my-5">
                        Put "Job Application" as the subject of your email
                        and attach your resume.
                    </p>

                    <div x-data="{ open: false }" @keydown.escape="open = false">

                        <button
                            class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                            x-on:click="open = !open">
                            Apply Now
                        </button>

                        <div class="fixed z-10 inset-0 bg-gray-900 flex justify-center items-center bg-opacity-50" x-cloak
                            x-show="open" x-transition>
                            <div @click.away="open = false" class="bg-white p-8 w-full max-w-md shadow-md rounded-lg">
                                <h3 class="font-semibold text-lg mb-4">Apply for {{ $job->title }}</h3>
                                <form method="POST" action="{{ route('jobs.apply', $job) }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <x-inputs.text type="hidden" name="job_id" value="{{ $job->id }}" />
                                    <x-inputs.text name="full_name" label="Full Name" id="full_name" :required="true" />
                                    <x-inputs.text type="tel" :required="true" name="contact_phone"
                                        label="Contact Phone" id="contact_phone" />
                                    <x-inputs.text name="contact_email" label="Contact Email" id="contact_email" />
                                    <x-inputs.text name="location" label="Full Name" id="location" />
                                    <x-inputs.textarea name="message" label="Message" id="message" />
                                    <x-inputs.file :required="true" name="resume" id="resume"
                                        label="Attach your resume" />

                                    <x-button type="submit">Apply</x-button>
                                    <x-button type="cancel" @click="open=false"
                                        class="bg-gray-600 hover:bg-gray-700">Cancel</x-button>

                                </form>

                            </div>

                        </div>
                    </div>
                @else
                    <p
                        class="bg-gray-200 rounded-lg flex items-baseline gap-4 py-2 px-4 text-sm text-blue-900 mt-6 text-center">
                        <i class="fas fa-info-circle"></i>
                        You must logged in for
                        applying jobs
                    </p>
                @endauth
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <div id="map" style="width: 100%; height: 400px;"></div>
                <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=34f426cd-8cba-4aba-a899-81f478fa2eb5"
                    type="text/javascript"></script>
                <script>
                    ymaps.ready(init);

                    function init() {
                        var myMap = new ymaps.Map("map", {
                            center: [55.76, 37.64], // координаты центра карты (Москва)
                            zoom: 10 // масштаб карты
                        });

                        // Добавление метки
                        var myPlacemark = new ymaps.Placemark([55.76, 37.64], {
                            balloonContent: 'Москва'
                        });

                        myMap.geoObjects.add(myPlacemark);
                    }
                </script>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-xl text-center mb-4 font-bold">
                Company Info
            </h3>
            @if ($job->company_logo)
                <img src="/storage/{{ $job->company_logo }}" alt="Ad" class="w-full rounded-lg mb-4 m-auto" />
            @endif

            <h4 class="text-lg font-bold">{{ $job->company_name }}</h4>

            <p class="text-gray-700 text-lg my-3">
                {{ $job->company_description }}
            </p>

            @if ($job->company_website)
                <a href="{{ $job->company_website }}" target="_blank" class="text-blue-500">Visit Website</a>
            @endif

            @guest
                <p
                    class="bg-gray-200 rounded-lg flex items-baseline gap-4 py-2 px-4 text-sm text-blue-900 mt-6 text-center">
                    <i class="fas fa-info-circle"></i>
                    You must logged in for
                    bookmark
                </p>
            @else
                @if (Auth::user()->isBookmarkedJob($job))
                    <form action="{{ route('jobs.bookmarked.destroy', $job) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="mt-10 bg-red-500 hover:bg-red-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center"><i
                                class="fas fa-bookmark mr-3"></i> Remove bookmark</button>
                    </form>
                @else
                    <form action="{{ route('jobs.bookmarked.store', $job) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="mt-10 bg-blue-500 hover:bg-blue-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center"><i
                                class="fas fa-bookmark mr-3"></i> Bookmark
                            Listing</button>
                    </form>
                @endif


            @endguest



        </aside>
    </div>
</x-layout>
