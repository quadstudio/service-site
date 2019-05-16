@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::equipment.equipments')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::equipment.icon')"></i> @lang('site::equipment.equipments')
        </h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.equipments.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::equipment.equipment')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $equipments])@endpagination
        {{$equipments->render()}}
        @foreach($equipments as $equipment)
            <div class="card my-4" id="equipment-{{$equipment->id}}">
                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.equipments.show', $equipment)}}" class="text-big mr-3">
                            {{$equipment->name}}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        <a class="mr-3" href="{{route('admin.catalogs.show', $equipment->catalog)}}">
                            {{$equipment->catalog->name}}
                        </a>
                        @component('site::components.bool.pill', ['bool' => $equipment->enabled])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-sm-12">
                        @if($equipment->images()->exists())
                            <div class="row p-2">
                                <div class="col">@include('site::admin.image.preview', ['image' => $equipment->images()->orderBy('sort_order')->first()])</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-sm-12">
                        <dl class="dl-horizontal mt-sm-2">
                            @if($equipment->products()->exists())
                                <dt class="col-12">@lang('site::catalog.products')</dt>
                                <dd class="col-12">
                                    <div class="list-group">
                                        @foreach($equipment->products as $product)
                                            <a href="{{route('admin.products.show', $product)}}"
                                               class="list-group-item-action">
                                                {{$product->name}} ({{$product->sku}})
                                            </a>
                                        @endforeach
                                    </div>
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-12">
                        @if($equipment->annotation)
                            <dl class="dl-horizontal mt-sm-2">
                                <dt class="col-12">@lang('site::equipment.annotation')</dt>
                                <dd class="col-12">{!! $equipment->annotation !!}</dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-2 col-sm-12">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::messages.show_ferroli')
                                <span>@bool(['bool' => $equipment->show_ferroli])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::messages.show_lamborghini')
                                <span>@bool(['bool' => $equipment->show_lamborghini])@endbool</span>
                            </dt>
                        </dl>
                    </div>

                </div>
            </div>
        @endforeach
        {{$equipments->render()}}
    </div>
@endsection
