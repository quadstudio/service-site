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
                @each('site::repair.index.row', $items, 'repair')
                {{$items->render()}}
            </div>
        </div>
    </div>
@endsection
