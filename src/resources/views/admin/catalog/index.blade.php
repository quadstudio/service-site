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
            <li class="breadcrumb-item active">@lang('site::catalog.catalogs') (@lang('site::catalog.grid'))</li>
        </ol>
        <h1 class="header-title mb-2"><i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')
            (@lang('site::catalog.grid'))</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.catalogs.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <i class="fa fa-folder-open"></i>
                <span>@lang('site::messages.add') @lang('site::catalog.catalog')</span>
            </a>
            <a href="{{ route('admin.catalogs.tree') }}"
               class="d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-secondary">
                <i class="fa fa-bars"></i>
                <span>@lang('site::messages.open') @lang('site::catalog.tree')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $catalogs])@endpagination
        {{$catalogs->render()}}
        @foreach($catalogs as $catalog)
            <div class="card my-4" id="catalog-{{$catalog->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.catalogs.show', $catalog)}}" class="text-large mr-3 ml-0">
                            {{ $catalog->name }}
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        @if($catalog->canAddCatalog())
                            <a class="btn btn-sm py-0 btn-ferroli" data-toggle="tooltip" data-placement="top"
                               title="@lang('site::messages.add') @lang('site::catalog.catalog')"
                               href="{{ route('admin.catalogs.create.parent', $catalog) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i> <i
                                        class="fa fa-@lang('site::catalog.icon')" aria-hidden="true"></i>
                            </a>
                        @endif
                        @if($catalog->canAddEquipment())
                            <a class="btn btn-sm py-0 btn-ferroli" data-toggle="tooltip" data-placement="top"
                               title="@lang('site::messages.add') @lang('site::equipment.equipment')"
                               href="{{ route('admin.equipments.create.parent', $catalog) }}">
                                <i class="fa fa-plus" aria-hidden="true"></i> <i
                                        class="fa fa-@lang('site::equipment.icon')" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::catalog.image_id')</dt>
                            <dd class="col-12">
                                @include('site::admin.image.preview', ['image' => $catalog->image])
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            @if($catalog->catalog)
                                <dt class="col-12">@lang('site::catalog.catalog_id')</dt>
                                <dd class="col-12">
                                    <div class="list-group">
                                        <a href="{{route('admin.catalogs.show', $catalog->catalog)}}"
                                           class="list-group-item-action">{{ $catalog->catalog->name }}
                                        </a>
                                    </div>
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            @if($catalog->catalogs()->exists())
                                <dt class="col-12">@lang('site::catalog.children')</dt>
                                <dd class="col-12">
                                    <div class="list-group">
                                        @foreach($catalog->catalogs as $children)
                                            <a href="{{route('admin.catalogs.show', $children)}}"
                                               class="list-group-item-action">{{$children->name}}
                                            </a>
                                        @endforeach
                                    </div>
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            @if($catalog->equipments()->exists())
                                <dt class="col-12">@lang('site::catalog.products')</dt>
                                <dd class="col-12">
                                    <div class="list-group">
                                        @foreach($catalog->equipments as $equipment)
                                            <a href="{{route('admin.equipments.show', $equipment)}}"
                                               class="list-group-item-action">{{$equipment->name}}
                                            </a>
                                        @endforeach
                                    </div>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$catalogs->render()}}
    </div>
@endsection
