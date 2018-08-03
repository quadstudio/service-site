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
            <li class="breadcrumb-item active">@lang('site::user.users')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::user.icon')"></i> @lang('site::user.users')
        </h1>

        @alert()@endalert

        <div class="row">
            <div class="col-sm-12">
                {{$users->render()}}
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                @filter(['repository' => $repository])@endfilter
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col"></th>
                        <th scope="col">@lang('site::user.name') / @lang('site::contact.sc')</th>
                        {{--<th scope="col" class="d-none d-sm-table-cell">@lang('site::user.sc')</th>--}}
                        <th scope="col" class="d-none d-sm-table-cell">@lang('site::address.region_id')
                            <br/>@lang('site::address.locality')</th>
                        <th scope="col" class="d-none d-sm-table-cell text-center">@lang('site::price.type_id')</th>
                        <th scope="col" class="text-center"><span
                                    class="d-none d-md-block">@lang('site::user.verified')</span></th>
                        <th scope="col" class="text-center"><span
                                    class="d-none d-sm-block">@lang('site::user.is_asc')</span></th>
                        <th scope="col" class="text-center">ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.user.index.row', $users, 'user')
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                {{$users->render()}}
            </div>
        </div>
    </div>
@endsection
