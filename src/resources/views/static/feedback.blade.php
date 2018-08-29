@extends('layouts.app')

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@push('scripts')
<script>
    let myMap;

    ymaps.ready(init);

    function init () {
        myMap = new ymaps.Map('contact-map', {
            center: [55.76, 37.64],
            zoom: 8,
            controls: ['zoomControl', 'typeSelector',  'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        });

        ymaps.geocode('Россия, Москва, Дмитровское ш 71 Б', {results: 1}).then(function (res) {

            console.log(res.geoObjects.get(0).geometry.getCoordinates());

            let firstGeoObject = res.geoObjects.get(0);
            let c = firstGeoObject.geometry.getCoordinates();

            let myPlacemark = new ymaps.Placemark(c, {
                    balloonContent: '<p><b>Представительство Ferroli</b></p>' + '<p>Россия, Москва, Дмитровское ш 71 Б</p>',
                    iconContent: 'FERROLI'
                }, {
                    preset: 'islands#redStretchyIcon',
                }
            );
            myMap.geoObjects.add(myPlacemark);

            myMap.setBounds(myMap.geoObjects.getBounds(), {checkZoomRange: true});
        });
    }
</script>
@endpush
@section('header')
    @include('site::header.front',[
        'h1' => 'Контакты',
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => 'Контакты']
        ]
    ])
@endsection
@section('content')
    <section class="p-0">
        <div class="contact-map" id="contact-map"></div>
    </section>

    <section>
        <div class="container">
            @alert()@endalert
            <div class="row">
                <div class="col-sm-6 col-lg-5 mb-5">
                    <p>ООО «ФерролиРус»</p>
                    <p>127238, Москва, Дмитровское ш 71 Б</p>
                    <hr/>
                    <p>Тел. (495) 646 06 23</p>
                    <p>Email: info@ferroli.ru</p>
                </div>
                <div class="d-none d-lg-block col-lg-2"></div>
                <div class="col-sm-6 col-lg-5">
                    <form action="{{route('message')}}" method="POST" autocomplete="off">
                        @csrf
                        <div class="control-group form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <input name="name" type="text" placeholder="ИМЯ" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                        </div>
                        <div class="control-group form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <input name="email" type="text" placeholder="EMAIL" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        </div>
                        <div class="control-group form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <textarea name="message" placeholder="СООБЩЕНИЕ" rows="4" class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"></textarea>
                        </div>
                        <div class="control-group form-group">
                            <button type="submit" class="btn btn-ferroli">ОТПРАВИТЬ</button>
                        </div>
                        <div class="form-error" style="display: none;">Возникла ошибка</div>
                        <div class="form-success" style="display: none;">Сообщение отправлено</div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
