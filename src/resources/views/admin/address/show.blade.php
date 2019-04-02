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
                balloonContent: '{{$address->full}}'
            }, {
                preset: 'islands#blackIcon',
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
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.'.$address->addressable->path().'.index') }}">@lang('site::'.$address->addressable->lang().'.'.$address->addressable->path())</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.'.$address->addressable->path().'.show', $address->addressable) }}">{{$address->addressable->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.'.$address->addressable->path().'.addresses.index', $address->addressable) }}">@lang('site::address.addresses')</a>
            </li>
            <li class="breadcrumb-item active">{{ $address->full }}</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::address.icon')"></i> {{ $address->full }}
        </h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.addresses.edit', $address) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::address.address')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.addresses.phones.create', $address) }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::phone.phone')</span>
            </a>
            @if($address->type_id == 6)
                <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
                   href="{{ route('admin.addresses.regions.index', $address) }}"
                   role="button">
                    <i class="fa fa-map-marker"></i>
                    <span>@lang('site::address.regions') <span
                                class="badge badge-light">{{$address->regions->count()}}</span></span>
                </a>
            @endif
            <a href="{{ route('admin.'.$address->addressable->path().'.addresses.index', $address->addressable) }}"
               class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.addressable.'.$address->addressable_type)</dt>
                    <dd class="col-sm-8">
                        <a href="{{ route('admin.'.$address->addressable_type.'.show', $address->addressable) }}">{{ $address->addressable->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.type_id')</dt>
                    <dd class="col-sm-8">{{ $address->type->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.regions')</dt>
                    <dd class="col-sm-8">
                        <ul class="list-group">
                            @foreach($address->regions as $region)
                                <li class="list-group-item p-1">{{$region->name}}</li>
                            @endforeach
                        </ul>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.email')</dt>
                    <dd class="col-sm-8"> {{ $address->email }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.web')</dt>
                    <dd class="col-sm-8"> {{ $address->web }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.active')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $address->active])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.is_shop')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $address->is_shop])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.is_eshop')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $address->is_eshop])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.is_service')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $address->is_service])@endbool</dd>

                    @if($address->name)
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.name')</dt>
                        <dd class="col-sm-8">{{ $address->name }}</dd>
                    @endif
                    @if($address->name)
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.sort_order')</dt>
                        <dd class="col-sm-8">{{ $address->sort_order }}</dd>
                    @endif
                    {{--@if(($phones = $address->phones())->count() > 0)--}}
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
                                            <a href="{{route('admin.phones.edit', $phone)}}"
                                               class="dropdown-item">@lang('site::messages.edit')</a>
                                            <button @cannot('delete', $phone) disabled @endcannot
                                            class="dropdown-item btn-row-delete"
                                                    data-form="#phone-delete-form-{{$phone->id}}"
                                                    data-btn-delete="@lang('site::messages.delete')"
                                                    data-btn-cancel="@lang('site::messages.cancel')"
                                                    data-label="@lang('site::messages.delete_confirm')"
                                                    data-message="@lang('site::messages.delete_sure') @lang('site::phone.phone')? "
                                                    data-toggle="modal" data-target="#form-modal"
                                                    href="javascript:void(0);"
                                                    title="@lang('site::messages.delete')">
                                                @lang('site::messages.delete')
                                            </button>
                                            <form id="phone-delete-form-{{$phone->id}}"
                                                  action="{{route('admin.phones.destroy', $phone)}}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                    {{$phone->country->phone}} {{$phone->number}}
                                </div>
                            </div>

                        @endforeach
                    </dd>
                    {{--@endif--}}
                    <dt class="col-sm-4 text-left text-sm-right"></dt>
                    <dd class="col-sm-8">
                        <div id="address-map" style="height: 320px;width: 100%;"></div>
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
