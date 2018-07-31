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

        ymaps.geocode('РБ, г.Минск, ул. Ленина, д.5', {results: 1}).then(function (res) {

            console.log(res.geoObjects.get(0).geometry.getCoordinates());

            let firstGeoObject = res.geoObjects.get(0);
            let c = firstGeoObject.geometry.getCoordinates();

            let myPlacemark = new ymaps.Placemark(c, {
                    balloonContent: '<p><b>Представительство Ferroli</b></p>' + '<p>РБ, г.Минск, ул. Ленина, д.5</p>',
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
            <div class="row">
                <div class="col-sm-6 col-lg-5 mb-5">
                    <p>Для быстрой, экспертной помощи и консультаций по всем нашим отопительным приборам, запасным частям, технической поддержке и обучению есть специальная команда, ожидающая вашего звонка. Вот номера телефонов и адреса электронной почты, которые вам нужны:</p>
                    <hr/>
                    <p>Ferroli S.p.A. via Ritonda 78/a 37047 San Bonifacio (VR)</p>
                    <hr/>
                    <p>Телефон: +39 045 6139411</p>
                    <p>Email: info@ferroli.ru</p>
                </div>
                <div class="d-none d-lg-block col-lg-2"></div>
                <div class="col-sm-6 col-lg-5">
                    <form action="" method="POST" autocomplete="off">
                        <div class="control-group form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <input name="name" type="text" placeholder="ИМЯ" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        </div>
                        <div class="control-group form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <input name="email" type="text" placeholder="EMAIL" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        </div>
                        <div class="control-group form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <textarea name="message" placeholder="СООБЩЕНИЕ" rows="4" class="{{ $errors->has('message') ? 'is-invalid' : '' }}"></textarea>
                        </div>
                        <div class="control-group form-group">
                            <button type="submit">ОТПРАВИТЬ</button>
                        </div>
                        <div class="form-error" style="display: none;">Возникла ошибка</div>
                        <div class="form-success" style="display: none;">Сообщение отправлено</div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
