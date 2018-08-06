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
        <div class="justify-content-start border p-3 mb-4">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('admin.equipments.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::equipment.equipment')</span>
            </a>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                {{$equipments->render()}}
                @filter(['repository' => $repository])@endfilter
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::equipment.name')</th>
                        <th scope="col">@lang('site::equipment.catalog_id')</th>
                        <th scope="col">@lang('site::image.images')</th>
                        <th scope="col" class="text-center">ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.equipment.index.row', $equipments, 'equipment')
                    </tbody>
                </table>
                {{$equipments->render()}}
            </div>
        </div>
   </div>
@endsection
