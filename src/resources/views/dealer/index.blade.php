@extends('layouts.app')
@section('title')@lang('site::dealer.dealers')@lang('site::messages.title_separator')@endsection
@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@section('header')
    @include('site::header.front',[
        'h1' => '<i class="fa fa-'.__('site::dealer.icon').'"></i> '.__('site::dealer.dealers'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::dealer.dealers')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-sm-0 col-sm-12 offset-1 col-10">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{route('dealers.index')}}">
                            @csrf
                            <div class="input-group mb-3">
                                <select class="form-control" name="filter[region_id]" title="">
                                    <option @if(is_null($region_id)) selected @endif value="">- все регионы -</option>
                                    @foreach($regions as $region)
                                        <option value="{{$region->id}}"
                                                @if($region->id == $region_id) selected @endif>{{$region->name}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-ferroli" type="submit">Показать</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h4 class="py-0" id="row-count">
                            Загрузка данных...
                        </h4>
                    </div>
                    <div class="col-sm-12 text-center" id="loading-data">
                        <img src="{{asset('images/loading.gif')}}">
                    </div>
                    <div class="col-sm-12">
                        <div class="addresses-map mb-5" id="addresses-map"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3 id="addresses-list">Список дилеров</h3>
                        <div id="container-addresses" data-region="{{$region_id}}"
                             data-action="{{route('api.dealers.index')}}"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
