@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
        <h1 class="header-title m-t-0 m-b-20">@if($catalog->model) @lang('site::catalog.model') @endif {{ $catalog->name }}</h1>
        <hr/>

        @include('alert')

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('admin.catalogs.edit', $catalog) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>

                <a href="{{ route('admin.catalogs.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
                @if($catalog->canAddCatalog())
                    <a class="btn btn-success" href="{{ route('admin.catalogs.create.parent', $catalog) }}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                        @lang('site::messages.add') @lang('site::catalog.catalog')
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col">

                <table class="table table-sm table-bordered">
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
                        <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.model')</b></td>
                        <td class="col-6 col-sm-9">@include('site::admin.catalog.field.model')</td>
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
                        <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.name_plural')</b></td>
                        <td class="col-6 col-sm-9">{{ $catalog->name_plural }}</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.description')</b></td>
                        <td class="col-6 col-sm-9">{{ $catalog->description }}</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog_image.images')</b></td>
                        <td class="col-6 col-sm-9">
                            @include('site::admin.catalog.images')
                        </td>
                    </tr>

                    <tr class="d-flex">
                        @if(!$catalog->model)
                            <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.children')</b></td>
                            <td class="col-6 col-sm-9">
                                <div class="list-group">
                                    @foreach($catalog->catalogs as $children)
                                        <a class="list-group-item"
                                           href="{{route('admin.catalogs.show', $children)}}">{{ $children->name }}</a>
                                    @endforeach
                                </div>
                            </td>
                        @else
                            <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.products')</b></td>
                            <td class="col-6 col-sm-9">
                                <div class="list-group">
                                    @foreach($catalog->products as $product)
                                        <a class="list-group-item"
                                           href="#">{{ $product->name }}</a>
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
