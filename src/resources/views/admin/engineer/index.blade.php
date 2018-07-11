@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::engineer.engineers')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-user"></i> @lang('site::engineer.engineers')</h1>
        <hr/>
        @include('site::alert')
        <div class="row">
            <div class="col-sm-12">
                {{$items->render()}}
            </div>
        </div>

        @include('repo::filter')

        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::engineer.name')</th>
                        <th scope="col">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.engineer.index.row', $items, 'item')
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
