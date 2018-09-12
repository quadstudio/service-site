@extends('layouts.app')

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endpush

@push('scripts')
<script>
    let myMap;

    ymaps.ready(init);

    function init() {
        myMap = new ymaps.Map('address-map', {
            center: [{{$address->geo}}],
            zoom: 12,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
        }, {
            searchControlProvider: 'yandex#search'
        });
        myMap.geoObjects
            .add(new ymaps.Placemark([{{$address->geo}}], {
                iconContent: '{{$address->name}}',
                balloonContent: '{{$address->full}}'
            }, {
                preset: 'islands#blackStretchyIcon',
                iconColor: '#0095b6'
            }))
    }
</script>
@endpush
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            @if($address->addressable_type == 'contragents')
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('contragents.show', $address->addressable) }}">{{$address->addressable->name}}</a>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ route('addresses.index') }}">@lang('site::address.addresses')</a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $address->type->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::address.icon')"></i> {{ $address->type->name }}</h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('addresses.edit', $address) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::address.address')</span>
            </a>
            @if($address->addressable_type == 'users')
                <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
                   href="{{ route('addresses.phone', $address) }}"
                   role="button">
                    <i class="fa fa-plus"></i>
                    <span>@lang('site::messages.add') @lang('site::phone.phone')</span>
                </a>
            @endif
            @if($address->addressable_type == 'contragents')
                <a href="{{ route('contragents.show', $address->addressable) }}"
                   class="d-block d-sm-inline btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::contragent.help.back')</span>
                </a>
            @else
                <a href="{{ route('addresses.index') }}" class="d-block d-sm-inline btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            @endif
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h4 class="card-title">{{$address->name}}</h4>

                <dl class="row">

                    {{--<dt class="col-sm-4 text-left text-sm-right">@lang('site::address.country_id')</dt>--}}
                    {{--<dd class="col-sm-8">--}}
                    {{--<img style="width: 30px;" class="img-fluid border"--}}
                    {{--src="{{ asset($address->country->flag) }}"--}}
                    {{--alt="">--}}
                    {{--{{$address->country->name}}--}}
                    {{--</dd>--}}

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.type_id')</dt>
                    <dd class="col-sm-8"> {{ $address->type->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.full')</dt>
                    <dd class="col-sm-8"> {{ $address->full }}</dd>

                    @if($address->addressable_type == 'contragents')
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.addressable.'.$address->addressable_type)</dt>
                        <dd class="col-sm-8">
                            <a href="{{ route('contragents.show', $address->addressable) }}">{{ $address->addressable->name }}</a>
                        </dd>
                    @endif

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::phone.phones')</dt>
                    <dd class="col-sm-8">
                        @foreach($address->phones as $phone)
                            <div class="card mb-1" id="phone-{{$phone->id}}">
                                <div class="card-body">
                                    <div class="items-dropdown btn-group">
                                        <button type="button"
                                                class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                                             x-placement="bottom-end"
                                             style="position: absolute; will-change: top, left; top: 26px; left: -134px;">
                                            <a @can('edit', $phone)
                                               href="{{route('phones.edit', $phone)}}"
                                               class="dropdown-item"
                                               @else()
                                               href="javascript:void(0);"
                                               class="disabled dropdown-item"
                                                    @endcan>@lang('site::messages.edit')</a>
                                            <button @cannot('delete', $phone) disabled @endcannot
                                            class="dropdown-item btn-row-delete"
                                                    data-form="#phone-delete-form-{{$phone->id}}"
                                                    data-btn-delete="@lang('site::messages.delete')"
                                                    data-btn-cancel="@lang('site::messages.cancel')"
                                                    data-label="@lang('site::messages.delete_confirm')"
                                                    data-message="@lang('site::messages.delete_sure') @lang('site::phone.phone')? "
                                                    data-toggle="modal" data-target="#form-modal"
                                                    href="javascript:void(0);" title="@lang('site::messages.delete')">
                                                @lang('site::messages.delete')
                                            </button>
                                            <form id="phone-delete-form-{{$phone->id}}"
                                                  action="{{route('phones.destroy', $phone)}}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                    <a href="{{route('phones.edit', $phone)}}">{{$phone->format()}}</a>
                                </div>
                            </div>

                        @endforeach
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right"></dt>
                    <dd class="col-sm-8">
                        <div id="address-map" style="height: 320px;width: 100%;"></div>
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
