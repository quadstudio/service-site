@extends('layouts.app')

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@section('header')
    @include('site::header.front',[
        'h1' => '<i class="fa fa-cog"></i> '.__('site::service.services'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::service.services')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 col-lg-3 mt-5">
                <b class="d-block mb-2">@lang('site::service.checkboxes.title')</b>
                <div class="form-row">
                    <div class="col mb-3">
                        <div class="custom-control custom-checkbox">
                            <input name="asc"
                                   value="asc"
                                   type="checkbox"
                                   checked
                                   class="custom-control-input" id="asc">
                            <label class="custom-control-label"
                                   for="asc">@lang('site::service.checkboxes.asc')</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mb-3">
                        <div class="custom-control custom-checkbox">
                            <input name="dealer"
                                   value="dealer"
                                   type="checkbox"
                                   checked
                                   class="custom-control-input" id="dealer">
                            <label class="custom-control-label"
                                   for="dealer">@lang('site::service.checkboxes.dealer')</label>
                        </div>
                    </div>
                </div>
                <b class="d-block mb-2">@lang('site::service.regions')</b>
                <div class="list-group"
                     id="services-region-list"
                     data-action="{{route('api.services.index')}}">
                    @foreach($regions as $region)
                        <a href="#"
                           data-region="{{$region->id}}"
                           class="services-region-select list-group-item list-group-item-action p-2">{{$region->name}}</a>
                    @endforeach
                </div>
                {{--<div class="control-group form-group">--}}
                {{--<button id="search-service" type="submit">Поиск</button>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-6 col-lg-9 mt-5">
                <div class="row">
                    <div class="col-12">
                        Найдено: <span class="text-big" id="row-count">0</span>
                    </div>
                    <div class="col-12">
                        <div class="service-map mb-5" id="service-map"></div>
                    </div>
                    <div class="col-12">
                        <div id="container-service"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
