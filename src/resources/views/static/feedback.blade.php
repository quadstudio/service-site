@extends('layouts.app')

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@push('scripts')
<script>
    let myMap;

    ymaps.ready(init);

    function init() {
        myMap = new ymaps.Map('contact-map', {
            center: [55.76, 37.64],
            zoom: 8,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
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
                    <h4>@lang('site::feedback.feedback')</h4>

                    <form action="{{route('message')}}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-row required">
                            <div class="col mb-3">
                                <input name="name" type="text" placeholder="@lang('site::feedback.name')"
                                       required
                                       class="mb-0 form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="form-row required">
                            <div class="col mb-3">
                                <input name="email" type="email" placeholder="@lang('site::feedback.email')"
                                       required
                                       class="mb-0 form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-row required">
                            <div class="col mb-3">
                            <textarea name="message" placeholder="@lang('site::feedback.message')" rows="4"
                                      required
                                      class="mb-0 form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"></textarea>
                                <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                            </div>
                        </div>
                        <p class="text-muted text-small">@lang('site::feedback.require')</p>
                        <div class="control-group form-group">
                            <button type="submit" class="btn btn-ferroli"><i
                                        class="fa fa-send"></i> @lang('site::messages.send')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
