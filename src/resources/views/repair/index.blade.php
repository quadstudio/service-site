@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')</h1>
        <hr/>

        @alert()@endalert()

        {{--<div class="row">--}}
            {{--<div class="col-12 mb-2">--}}
                {{--<a class="btn btn-success" href="{{ route('repairs.create') }}" role="button">--}}
                    {{--<i class="fa fa-magic"></i>--}}
                    {{--<span>@lang('site::messages.create') @lang('site::repair.repair')</span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="row">
            <div class="col-sm-12">
                {{--<vue-pagination :pagination="pagination" @paginate="getRepairs()" :offset="2"></vue-pagination>--}}
                {{$items->render()}}
            </div>
        </div>

        @include('repo::filter')

        <div class="row">
            <div class="col-12">

                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::repair.number')</th>
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::repair.client')</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--<tr v-for="repair in repairs">--}}
                        {{--<td>@{{ repair.number }}</td>--}}
                        {{--<td>@{{ repair.client }}</td>--}}
                    {{--</tr>--}}
                    @each('site::repair.row', $items, 'item')
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
