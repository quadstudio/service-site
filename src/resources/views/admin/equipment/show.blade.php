@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.equipments.index') }}">@lang('site::equipment.equipments')</a>
            </li>

            <li class="breadcrumb-item active">{{ $equipment->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $equipment->name }}</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.equipments.edit', $equipment) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::equipment.equipment')</span>
            </a>
            <a href="{{ route('admin.equipments.images.index', $equipment) }}"
               class="d-block mr-0 mr-sm-1 mb-1 mb-sm-0 d-sm-inline btn btn-ferroli">
                <i class="fa fa-image"></i>
                <span>@lang('site::image.images')</span>
                <span class="badge badge-light">{{$equipment->images()->count()}}</span>
            </a>
            <a href="{{ route('admin.equipments.index') }}"
               class="d-block mr-0 mr-sm-1 mb-1 mb-sm-0 d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

            @can('delete', $equipment)
                <a class="d-block d-sm-inline text-white btn btn-danger btn-row-delete"
                   data-form="#equipment-delete-form-{{$equipment->id}}"
                   data-btn-delete="@lang('site::messages.delete')"
                   data-btn-cancel="@lang('site::messages.cancel')"
                   data-label="@lang('site::messages.delete_confirm')"
                   data-message="@lang('site::messages.delete_sure') @lang('site::equipment.equipment')? "
                   data-toggle="modal" data-target="#form-modal"
                   href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                            class="fa fa-close"></i> @lang('site::messages.delete')
                </a>
                <form id="equipment-delete-form-{{$equipment->id}}"
                      action="{{route('admin.equipments.destroy', $equipment)}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            @endcan
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">



                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $equipment->enabled])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_ferroli')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $equipment->show_ferroli])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_lamborghini')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $equipment->show_lamborghini])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.name')</dt>
                    <dd class="col-sm-8">{{ $equipment->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.h1')</dt>
                    <dd class="col-sm-8">{{ $equipment->h1 }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.title')</dt>
                    <dd class="col-sm-8">{{ $equipment->title }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.metadescription')</dt>
                    <dd class="col-sm-8">{{ $equipment->metadescription }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.annotation')</dt>
                    <dd class="col-sm-8">{!! $equipment->annotation !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.description')</dt>
                    <dd class="col-sm-8">{!! $equipment->description !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.catalog_id')</dt>
                    <dd class="col-sm-8">
                        @foreach($equipment->catalog->parentTree()->reverse() as $element)
                            <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name_plural }}</a>
                            @if(!$loop->last)
                                <span class="px-1">/</span>
                            @endif
                        @endforeach
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.header.boiler')</dt>
                    <dd class="col-sm-8">
                        @foreach($equipment->products as $product)
                            <a class="d-block mr-2"
                               href="{{route('admin.products.show', $product)}}">
                                @if($product->enabled)
                                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::product.enabled')"
                                       class="fa fa-check text-success"></i>
                                @else
                                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::product.enabled')"
                                       class="fa fa-close text-danger"></i>
                                @endif
                                {{$product->name}}
                            </a>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::image.images')</dt>
                    <dd class="col-sm-8">
                        <div class="row">
                            @foreach($equipment->images()->orderBy('sort_order')->get() as $image)
                                <div class="col-md-4">@include('site::admin.image.preview')</div>
                            @endforeach
                        </div>
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection
