@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">Маршруты</li>
        </ol>
        <h1 class="header-title mb-4">Маршруты</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-scheme d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Обработчик</th>
                        <th>Префикс</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($routes as $route)
                        <tr>
                            <td>{{$route->getName()}}</td>
                            <td>{{$route->getActionName()}}</td>
                            <td>{{$route->getPrefix()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
