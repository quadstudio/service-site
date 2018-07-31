@extends('layouts.app')

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@push('scripts')
<script>
    let myMap;
    let objectManager;

    ymaps.ready(init);

    function init () {
        myMap = new ymaps.Map('service-map', {
            center: [55.76, 37.64],
            zoom: 10,
            controls: ['zoomControl', 'typeSelector',  'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        });

        objectManager = new ymaps.ObjectManager({
            clusterize: false,
            gridSize: 64,
            clusterIconLayout: "default#pieChart"
        });
        myMap.geoObjects.add(objectManager);

    }

    function renderServiceList(data) {
        if(data.features !== undefined) {
            let containerService = document.getElementById("container-service");

            containerService.innerHTML = null;

            for(let key in data.features) {
                containerService.innerHTML += data.features[key].properties.balloonContentBody;
            }
        }
    }


    let searchService = document.getElementById('search-service');
    searchService.addEventListener('click', function(e){

        let region = document.getElementById('region-service').value;

        if(region !== 0) {
            fetch('/ff.php?region=' + region, {cache: 'no-store'})
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    myMap.geoObjects.remove(objectManager);
                    objectManager.removeAll();

                    objectManager.add(data);
                    myMap.geoObjects.add(objectManager);
                    myMap.container.fitToViewport();

                    myMap.setBounds(myMap.geoObjects.getBounds(), {checkZoomRange: true});

                    renderServiceList(data);
                })
                .catch( console.log('error fetch'));
        }
    });
</script>
@endpush

@section('header')
    @include('site::header.front',[
        'h1' => __('site::service.services'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::service.services')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-6 col-lg-5 mt-5">
                <div class="control-group form-group">
                    <label><strong>ВЫБЕРИТЕ РЕГИОН</strong></label>
                    <select id="region-service" name="region" title="">
                        <option value="0">выбрать</option>
                        <option value="5000000000000">Московская область</option>
                    </select>
                </div>
                <div class="control-group form-group">
                    <button id="search-service" type="submit">Поиск</button>
                </div>
            </div>
            <div class="col-sm-6 col-lg-7 mt-5">
                <div class="service-map mb-5" id="service-map"></div>
                <div  id="container-service"></div>
            </div>
        </div>
    </div>
@endsection
