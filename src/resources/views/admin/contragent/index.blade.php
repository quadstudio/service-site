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
            <li class="breadcrumb-item active">@lang('site::contragent.contragents')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')</h1>
        @alert()@endalert()
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        @filter(['repository' => $repository])@endfilter

        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::contragent.name')</th>
                        <th scope="col">@lang('site::user.name')</th>
                        <th scope="col">@lang('site::contragent.inn')</th>
                        <th scope="col">ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.contragent.index.row', $items, 'contragent')
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

    </div>
@endsection
