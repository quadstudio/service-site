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
            @foreach($equipment->catalog->parentTree()->reverse() as $element)
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.catalogs.show', $element) }}">{{ $element->name }}</a>
                </li>
            @endforeach
            <li class="breadcrumb-item active">{{ $equipment->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $equipment->name }}</h1>
        <hr/>

        @alert()@endalert

        <div class="row">
            <div class="col mb-2">
                <a href="{{ route('admin.equipments.edit', $equipment) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>

                <a href="{{ route('admin.equipments.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
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
                                    {{ $equipment->catalog->parentTreeName() }}
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.enabled')</b></td>
                                <td class="col-6 col-sm-9">
                                    @if($equipment->enabled)
                                        <i data-toggle="tooltip" data-placement="top"
                                           title="@lang('site::equipment.enabled')"
                                           class="fa fa-check text-success"></i>
                                    @else
                                        <i data-toggle="tooltip" data-placement="top"
                                           title="@lang('site::equipment.enabled')"
                                           class="fa fa-close text-secondary"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.name')</b></td>
                                <td class="col-6 col-sm-9">{{ $equipment->name }}</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::catalog.description')</b></td>
                                <td class="col-6 col-sm-9">{!! $equipment->description !!}</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-6 col-sm-3 text-right"><b>@lang('site::image.images')</b></td>
                                <td class="col-6 col-sm-9">
                                    @include('site::admin.equipment.images')
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
