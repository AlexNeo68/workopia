<x-layout>
    <x-slot name="title">Все студии</x-slot>

    <div class="bg-blue-900 flex justify-center py-4 mb-6 rounded">
        <x-search />
    </div>

    @if (request('keywords') || request('location'))
        <div class="mb-6">
            <a href="{{ route('studios.index') }}"
                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-700 cursor-pointer">
                <i class="fas fa-arrow-left"></i>
                <span>Назад</span>
            </a>
        </div>
    @endif

    @if ($studios->count())
        <div id="map" style="width: 100%; height: 400px;" class="mb-6"></div>
    @endif

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{ env('YANDEX_MAP_API_KEY') }}" type="text/javascript">
    </script>

    <script>
        let locations = [];

        function addLocation(coordinates, hint, balloonContent) {
            locations.push({
                coordinates,
                hint,
                balloonContent
            });
        }
    </script>





    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($studios as $studio)
            <x-studio-card :studio="$studio"></x-studio-card>
            @if ($studio->coordinates)
                <script>
                    addLocation('{{ $studio->coordinates }}', '{{ $studio->title }}', '{{ $studio->address }}');
                </script>
            @endif
        @empty
            <p>Студии не найдены...</p>
        @endforelse
    </div>
    {{ $studios->links('pagination::workopia') }}

    @if ($studios->count())
        <script>
            ymaps.ready(init);

            function init() {
                var myMap = new ymaps.Map("map", {
                    center: [55.755864, 37.617698], // координаты центра карты Москва
                    zoom: 10 // масштаб карты
                });



                locations.forEach(function(location) {

                    const arrCoord = location.coordinates.split(',');

                    const placemark = new ymaps.Placemark(
                        arrCoord, {
                            hintContent: location.hint,
                            balloonContent: location.balloonContent
                        }, {
                            preset: 'islands#icon',
                            iconColor: '#ff0000'
                        }
                    );
                    myMap.geoObjects.add(placemark);
                });

                if (locations.length > 1) {
                    myMap.setBounds(myMap.geoObjects.getBounds());
                    myMap.setZoom(myMap.getZoom() - 0.4);
                } else {
                    myMap.setCenter(locations[0].coordinates.split(','));
                }



            }
        </script>
    @endif






</x-layout>
