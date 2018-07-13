@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::engineer.engineers')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')</h1>

        @alert()@endalert

        <div class="row">
            <div class="col-12 mb-2">
                <nav class="nav nav-pills flex-column flex-sm-row">
                    <a class="flex-sm text-sm-center nav-link btn-success" href="{{ route('engineers.create') }}" role="button">
                        <i class="fa fa-plus"></i>
                        <span>@lang('site::messages.add')</span>
                    </a>

                </nav>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                {{$items->render()}}
                @filter(['repository' => $repository])@endfilter
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::engineer.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::engineer.country_id')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::engineer.phone')</th>
                        <th scope="col" class="d-none d-md-table-cell">@lang('site::engineer.address')</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::engineer.row', $items, 'item')
                    </tbody>
                </table>
                {{$items->render()}}
            </div>
        </div>

    </div>
@endsection
