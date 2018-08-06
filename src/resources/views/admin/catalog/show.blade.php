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
        <hr/>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-4">
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

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.full_name')</b></td>
                                <td class="col-6 col-sm-9">
                                    {{ $catalog->parentTreeName() }}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.enabled')</b></td>
                                <td class="col-6 col-sm-9">@include('site::admin.catalog.field.enabled')</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.catalog_id')</b></td>
                                <td class="col-6 col-sm-9">
                                    @if(!is_null($catalog->catalog))
                                        <a href="{{route('admin.catalogs.show', $catalog->catalog)}}">{{ $catalog->catalog->name }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.name')</b></td>
                                <td class="col-6 col-sm-9">{{ $catalog->name }}</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.description')</b></td>
                                <td class="col-6 col-sm-9">{{ $catalog->description }}</td>
                            </tr>
                            @if($catalog->canAddCatalog())
                                <tr class="d-flex">
                                    <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.children')</b></td>
                                    <td class="col-6 col-sm-9">
                                        <div class="list-group">
                                            @foreach($catalog->catalogs as $children)
                                                <a class="list-group-item"
                                                   href="{{route('admin.catalogs.show', $children)}}">{{ $children->name }}</a>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if($catalog->canAddEquipment())
                                <tr class="d-flex">
                                    <td class="col-6 col-sm-3 text-right"><b>@lang('site::equipment.equipments')</b>
                                    </td>
                                    <td class="col-6 col-sm-9">
                                        <div class="list-group">
                                            @foreach($catalog->equipments as $equipment)
                                                <a class="list-group-item"
                                                   href="{{route('admin.equipments.show', $equipment)}}">{{ $equipment->name }}</a>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
