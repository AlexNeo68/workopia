<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Studio Details Column -->
        <section class="md:col-span-3">
            <div class="rounded-lg shadow-md bg-white p-3">
                <div class="flex justify-between items-center">
                    <a class="block p-4 text-blue-700" href="{{ route('studios.index') }}">
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Назад в список
                    </a>

                    @can('update', $studio)
                        <div class="flex space-x-3 ml-4">
                            <a href="{{ route('studios.edit', $studio) }}"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
                            <!-- Delete Form -->
                            <form method="POST" action="{{ route('studios.destroy', $studio) }}"
                                onsubmit="return confirm('Are you shure that want to delete this studio?')">
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
                        {{ $studio->title }}
                    </h2>
                    <p class="text-gray-700 text-lg mt-2">{!! $studio->detail_text !!}</p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Средняя стоимость занятия:</strong>
                            {{ number_format($studio->cost_training, 0, '.', ' ') }}
                            &#8381;
                        </li>
                        <li class="mb-2">
                            <strong>Город:</strong> {{ $studio->city }}
                        </li>
                        <li class="mb-2">
                            <strong>Адрес:</strong> {{ $studio->address }}
                        </li>
                        <li class="mb-2">
                            <strong>Телефон:</strong> {{ $studio->contact_phone }}
                        </li>
                        <li class="mb-2">
                            <strong>Электронная почта:</strong> {{ $studio->contact_email }}
                        </li>
                        <li class="mb-2">
                            <strong>Теги:</strong> {{ ucwords(str_replace(',', ', ', $studio->tags)) }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="container mx-auto p-4">


                @auth
                    <p class="my-5">
                        Отправьте запрос на занятие и с вами свяжутся представители студии
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
                                <h3 class="font-semibold text-lg mb-4">Apply for {{ $studio->title }}</h3>
                                <form method="POST" action="{{ route('studios.apply', $studio) }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <x-inputs.text type="hidden" name="studio_id" value="{{ $studio->id }}" />
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
                        Вы должны быть авторизованы чтобы оставить заявку на занятие
                    </p>
                @endauth
            </div>

            @if ($studio->coordinates)
                <div class="bg-white p-6 rounded-lg shadow-md mt-6">

                    <div id="map" style="width: 100%; height: 400px;"></div>

                    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{ env('YANDEX_MAP_API_KEY') }}" type="text/javascript">
                    </script>
                    <script>
                        ymaps.ready(init);

                        function init() {
                            var myMap = new ymaps.Map("map", {
                                center: [{{ $studio->coordinates }}], // координаты центра карты
                                zoom: 10 // масштаб карты
                            });

                            // Добавление метки
                            var myPlacemark = new ymaps.Placemark([{{ $studio->coordinates }}], {
                                balloonContent: '{{ $studio->address }}'
                            });

                            myMap.geoObjects.add(myPlacemark);
                        }
                    </script>
                </div>
            @endif
        </section>

        <!-- Sidebar -->
        <aside class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-xl text-center mb-4 font-bold">
                О студии
            </h3>

            @if ($studio->getFirstMediaUrl('logo'))
                <img src="{{ $studio->getFirstMediaUrl('logo') }}" alt=""
                    class="w-full rounded-lg mb-4 m-auto" />
            @endif

            @if ($studio->company_logo)
                <img src="/storage/{{ $studio->company_logo }}" alt="Ad" class="w-full rounded-lg mb-4 m-auto" />
            @endif

            <h4 class="text-lg font-bold">{{ $studio->title }}</h4>

            <p class="text-gray-700 text-lg my-3">
                {{ $studio->preview_text }}
            </p>

            @if ($studio->website_link)
                <p><a href="{{ $studio->website_link }}" target="_blank" class="text-blue-500">Посетить сайт</a></p>
            @endif
            @if ($studio->vk_link)
                <p><a href="{{ $studio->vk_link }}" target="_blank" class="text-blue-500">Посетить группу в
                        контакте</a></p>
            @endif

            @guest
                <p
                    class="bg-gray-200 rounded-lg flex items-baseline gap-4 py-2 px-4 text-sm text-blue-900 mt-6 text-center">
                    <i class="fas fa-info-circle"></i>
                    Вы должны быть авторизованы чтобы добавить студию в избранное
                </p>
            @else
                @if (Auth::user()->isBookmarkedStudio($studio))
                    <form action="{{ route('studios.bookmarked.destroy', $studio) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="mt-10 bg-red-500 hover:bg-red-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center"><i
                                class="fas fa-bookmark mr-3"></i> Remove bookmark</button>
                    </form>
                @else
                    <form action="{{ route('studios.bookmarked.store', $studio) }}" method="POST">
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
