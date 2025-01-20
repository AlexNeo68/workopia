<x-layout>
    <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
        <h2 class="text-4xl text-center font-bold mb-4">
            Create Job Listing
        </h2>
        <form method="POST" action="{{ route('jobs.store') }}" enctype="multipart/form-data">

            @csrf

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>

            <x-inputs.text name="title" label="Job Title" placeholder="Software Engineer" />

            <x-inputs.text-area id="description" name="description" label="Job Description"
                placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..." />

            <x-inputs.text name="salary" type="number" label="Annual Salary" placeholder="50000" />

            <x-inputs.text-area id="requirements" name="requirements" label="Requirements"
                placeholder="Bachelor's degree in Computer Science" />

            <x-inputs.text-area id="benefits" name="benefits" label="Benefits"
                placeholder="Health insurance, 401k, paid time off" />

            <x-inputs.text name="tags" label="Tags (comma-separated)" placeholder="development,coding,java,python" />

            <x-inputs.select id="job_type" name="job_type" label="Job Type" :options="[
                'Full-Time' => 'Full-Time',
                'Part-Time' => 'Part-Time',
                'Contract' => 'Contract',
                'Temporary' => 'Temporary',
                'Internship' => 'Internship',
                'Volunteer' => 'Volunteer',
                'On-Call' => 'On-Call',
            ]" />

            <x-inputs.select id="remote" name="remote" label="Remote" :options="[
                0 => 'No',
                1 => 'Yes',
            ]" />

            <div id="map" style="width: 100%; height: 450px;"></div>

            <x-inputs.text name="address" id="address" label="Address" placeholder="123 Main St" />

            <x-inputs.text name="city" id="city" label="City" placeholder="Albanyt" />

            <x-inputs.text name="coordinates" id="coordinates" label="Coordinates" placeholder="0.00,0.00" />

            <x-inputs.text name="state" label="State" placeholder="NY" />

            <x-inputs.text name="zipcode" label="ZIP Code" placeholder="12201" />

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info
            </h2>

            <x-inputs.text name="company_name" label="Company Name" placeholder="Company Name" />

            <x-inputs.text-area id="company_description" name="company_description" label="Company Description"
                placeholder="Company Description" />

            <x-inputs.text name="company_website" type="url" label="Company Website" placeholder="Enter website" />

            <x-inputs.text name="contact_phone" label="Contact Phone" placeholder="Enter Phone" />

            <x-inputs.text name="contact_email" label="Contact Email" placeholder="Enter Email" />

            <x-inputs.file name="company_logo" id="company_logo" label="Company Logo" />

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
        </form>
    </div>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34f426cd-8cba-4aba-a899-81f478fa2eb5"
        type="text/javascript"></script>
    <script>
        // todo в script.js - город через PhpToJSObject - преобразует массив PHP в js
        ymaps.ready(init);

        function init() {
            <? if (empty($job->coordinates)) { ?>
            var inputAddress = document.getElementById("address"),
                inputCoords = document.getElementById("coordinates"),
                inputCity = document.getElementById("city"),
                myPlacemark,
                myMap = new ymaps.Map('map', {
                    center: [
                        55.753994,
                        37.622093
                    ],
                    zoom: 6,
                    controls: ['searchControl']
                }, {
                    //searchControlProvider: 'yandex#search'
                });
            ymaps.geocode('{{ auth()->user()->city }}', {
                results: 1
            }).then(function(res) {
                var firstGeoObject = res.geoObjects.get(0),
                    // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');
                //firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
                // Получаем строку с адресом и выводим в иконке геообъекта.
                //firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());

                // Добавляем первый найденный геообъект на карту.
                // myMap.geoObjects.add(firstGeoObject);
                // Масштабируем карту на область видимости геообъекта.
                myMap.setBounds(bounds, {
                    // Проверяем наличие тайлов на данном масштабе.
                    checkZoomRange: true
                });
            });
            <? } else { ?>
            var inputAddress = document.getElementById("address"),
                inputCoords = document.getElementById("coordinates"),
                inputCity = document.getElementById("city"),
                myPlacemark,
                myMap = new ymaps.Map('map', {
                    center: [
                        {{ $job->coordinates }}
                    ],
                    zoom: 10,
                    controls: ['searchControl']
                }, {
                    //searchControlProvider: 'yandex#search'
                });
            myMap.geoObjects
                .add(new ymaps.Placemark([{{ $job->coordinates }}], {
                    balloonContent: '{{ $job->address }}'
                }, {
                    preset: 'islands#icon',
                    iconColor: '#0095b6'
                }));
            <? } ?>
            // Слушаем клик на карте.
            myMap.events.add('click', function(e) {
                var coords = e.get('coords');

                // Если метка уже создана – просто передвигаем ее.
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    myMap.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function() {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress(coords);
            });

            // Создание метки.
            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }

            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress(coords) {
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function(res) {
                    var firstGeoObject = res.geoObjects.get(0),
                        address = firstGeoObject.getAddressLine(),
                        city = firstGeoObject.getLocalities()[0] !== undefined ? firstGeoObject.getLocalities()[0] :
                        '';


                    // console.log(firstGeoObject.getAdministrativeAreas());

                    coords = firstGeoObject.geometry.getCoordinates(),

                        myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: [
                                // Название населенного пункта или вышестоящее административно-территориальное образование.
                                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() :
                                firstGeoObject.getAdministrativeAreas(),
                                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                            ].filter(Boolean).join(', '),
                            // В качестве контента балуна задаем строку с адресом объекта.
                            balloonContent: address
                        });
                    inputAddress.value = address;
                    inputCoords.value = coords;
                    inputCity.value = city;
                });
            }
        }
    </script>

</x-layout>
