@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.catalogs.index') }}">@lang('site::catalog.catalogs')</a>
            </li>
            @foreach($catalog->parentTree()->reverse() as $element)
                @if(!$loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">
                        {{ $element->name }}
                    </li>
                @endif
            @endforeach
        </ol>
        <h1 class="header-title mb-2">{{ $catalog->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" role="button"
               href="{{ route('admin.catalogs.edit', $catalog) }}">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            @if($catalog->canAddCatalog())
                <a href="{{ route('admin.catalogs.create.parent', $catalog) }}"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-@lang('site::catalog.icon')" aria-hidden="true"></i>
                    <span>@lang('site::messages.add') @lang('site::catalog.catalog')</span>
                </a>
            @endif
            @if($catalog->canAddEquipment())
                <a href="{{ route('admin.equipments.create.parent', $catalog) }}"
                   class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-@lang('site::equipment.icon')" aria-hidden="true"></i>
                    <span>@lang('site::messages.add') @lang('site::equipment.equipment')</span>
                </a>
            @endif
            <a href="{{ route('admin.catalogs.index') }}"
               class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
            @can('delete', $catalog)
                <a class="d-block d-sm-inline text-white btn btn-danger btn-row-delete"
                   data-form="#catalog-delete-form-{{$catalog->id}}"
                   data-btn-delete="@lang('site::messages.delete')"
                   data-btn-cancel="@lang('site::messages.cancel')"
                   data-label="@lang('site::messages.delete_confirm')"
                   data-message="@lang('site::messages.delete_sure') @lang('site::catalog.catalog')? "
                   data-toggle="modal" data-target="#form-modal"
                   href="javascript:void(0);" title="@lang('site::messages.delete')"><i
                            class="fa fa-close"></i> @lang('site::messages.delete')
                </a>
                <form id="catalog-delete-form-{{$catalog->id}}"
                      action="{{route('admin.catalogs.destroy', $catalog)}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            @endcan
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $catalog->enabled == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.image_id')</dt>
                    <dd class="col-sm-8">
                        @include('site::admin.image.preview', ['image' => $catalog->image])
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.name')</dt>
                    <dd class="col-sm-8">{{ $catalog->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.name_plural')</dt>
                    <dd class="col-sm-8">{{ $catalog->name_plural }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.h1')</dt>
                    <dd class="col-sm-8">{!! $catalog->h1 !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.title')</dt>
                    <dd class="col-sm-8">{!! $catalog->title !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.metadescription')</dt>
                    <dd class="col-sm-8">{!! $catalog->metadescription !!}</dd>


                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.description')</dt>
                    <dd class="col-sm-8">{!! $catalog->description !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.catalog_id')</dt>
                    <dd class="col-sm-8">
                        @if(!is_null($catalog->catalog))
                            <a href="{{route('admin.catalogs.show', $catalog->catalog)}}">{{ $catalog->catalog->name }}</a>
                        @endif
                    </dd>
                    @if($catalog->canAddCatalog())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.children')</dt>
                        <dd class="col-sm-8">
                            <ul class="list-group" data-target="{{route('admin.catalogs.sort', $catalog)}}"
                                id="sort-list">
                                @foreach($catalog->catalogs()->orderBy('sort_order')->get() as $children)
                                    <li class="sort-item list-group-item p-1" data-id="{{$children->id}}">
                                        <i class="fa fa-arrows"></i>
                                        <a href="{{route('admin.catalogs.show', $children)}}">{{ $children->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                    @endif
                    @if($catalog->canAddEquipment())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.equipments')</dt>
                        <dd class="col-sm-8">
                            <ul class="list-group" data-target="{{route('admin.equipments.sort')}}" id="sort-list">
                                @foreach($catalog->equipments()->orderBy('sort_order')->get() as $equipment)
                                    <li class="sort-item list-group-item p-1" data-id="{{$equipment->id}}">
                                        <i class="fa fa-arrows"></i>
                                        <a href="{{route('admin.equipments.show', $equipment)}}">{{ $equipment->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection
