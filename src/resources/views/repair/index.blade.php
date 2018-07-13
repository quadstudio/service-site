@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
        </h1>


        @alert()@endalert()

        <div class="row">
            <div class="col-12 mb-2">
                <a class="btn btn-success" href="{{ route('repairs.create') }}" role="button">
                    <i class="fa fa-magic"></i>
                    <span>@lang('site::messages.create') @lang('site::repair.repair')</span>
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                {{$items->render()}}
                @filter(['repository' => $repository])@endfilter
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th rowspan="2" scope="col">@lang('site::repair.created_at')</th>
                        <th rowspan="2" scope="col">@lang('site::repair.number')</th>
                        <th class="text-center" colspan="3">Оплата, {{ Auth::user()->currency->symbol_right }}</th>
                        <th class="text-center" rowspan="2" scope="col">@lang('site::repair.status_id')</th>
                    </tr>
                    <tr>
                        <th class="text-right">@lang('site::repair.help.cost_work')</th>
                        <th class="text-right">@lang('site::repair.help.cost_road')</th>
                        <th class="text-right">@lang('site::repair.help.cost_parts')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::repair.index.row', $items, 'repair')
                    </tbody>
                </table>
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
