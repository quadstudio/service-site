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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name }}</a>
                </li>
            @endforeach

        </ol>
        <h1 class="header-title mb-4">{{ $catalog->name }}</h1>

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
            <a href="{{ route('admin.catalogs.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>

        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.name')</dt>
                    <dd class="col-sm-8">{{ $catalog->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.description')</dt>
                    <dd class="col-sm-8">{{ $catalog->description }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $catalog->enabled == 1])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.full_name')</dt>
                    <dd class="col-sm-8">{{ $catalog->parentTreeName() }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.catalog_id')</dt>
                    <dd class="col-sm-8">
                        @if(!is_null($catalog->catalog))
                            <a href="{{route('admin.catalogs.show', $catalog->catalog)}}">{{ $catalog->catalog->name }}</a>
                        @endif
                    </dd>


                    @if($catalog->canAddCatalog())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::catalog.children')</dt>
                        <dd class="col-sm-8">
                            <div class="list-group">
                                @foreach($catalog->catalogs as $children)
                                    <a class="list-group-item"
                                       href="{{route('admin.catalogs.show', $children)}}">{{ $children->name }}</a>
                                @endforeach
                            </div>
                        </dd>
                    @endif
                    @if($catalog->canAddEquipment())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::equipment.equipments')</dt>
                        <dd class="col-sm-8">
                            <div class="list-group">
                                @foreach($catalog->equipments as $equipment)
                                    <a class="list-group-item"
                                       href="{{route('admin.equipments.show', $equipment)}}">{{ $equipment->name }}</a>
                                @endforeach
                            </div>
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection
