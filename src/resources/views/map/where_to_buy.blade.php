@extends('layouts.app')
@section('title')@lang('site::map.where_to_buy.title')@lang('site::messages.title_separator')@endsection
@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@section('header')
    @include('site::header.front',[
        'h1' => '<i class="fa fa-'.__('site::map.where_to_buy.icon').'"></i> '
        .__('site::map.where_to_buy.title'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::map.where_to_buy.title')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-sm-0 col-sm-12 offset-1 col-10">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{route('where-to-buy')}}">
                            @csrf
                            <div class="input-group mb-2">
                                <select class="form-control" name="filter[region_id]" title="">
                                    <option value="">@lang('site::region.help.select_all')</option>
                                    @foreach($regions as $region)
                                        <option @if($region->id == $region_id) selected @endif
                                            value="{{$region->id}}">{{$region->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-ferroli" type="submit">@lang('site::messages.show')</button>
                                </div>
                            </div>
                            @if($authorization_types)

                                <div class="form-row">
                                    <div class="col">
                                        @foreach($authorization_types as $authorization_type)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       @if(empty($selected_authorization_types) || in_array($authorization_type->id, $selected_authorization_types))
                                                       checked
                                                       @endif
                                                       name="filter[authorization_type][]"
                                                       value="{{$authorization_type->id}}"
                                                       class="custom-control-input"
                                                       id="at-{{$authorization_type->id}}">
                                                <label class="custom-control-label"
                                                       for="at-{{$authorization_type->id}}">
                                                    {{$authorization_type->name}} {{$authorization_type->brand->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h4 class="py-0" id="row-count">
                            @lang('site::messages.data_load')
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
                        <h3 id="addresses-list">@lang('site::map.where_to_buy.header')</h3>
                        <div id="container-addresses" data-action="{{route('api.where-to-buy')}}"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
