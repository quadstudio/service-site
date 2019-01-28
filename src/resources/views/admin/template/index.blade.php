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
            <li class="breadcrumb-item active">@lang('site::template.templates')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::template.icon')"></i> @lang('site::template.templates')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-template d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.templates.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::template.template')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-template d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $templates])@endpagination
        {{$templates->render()}}
        <div class="card mb-2">
            <div class="card-body">
                <table class="table table-sm ">
                    <thead>
                    <tr>
                        <th>@lang('site::template.name')</th>
                        <th>@lang('site::template.title')</th>
                        <th>@lang('site::template.type_id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($templates as $template)
                        <tr>
                            <td><a href="{{route('admin.templates.show', $template)}}">{{$template->name}}</a></td>
                            <td>{{$template->title}}</td>
                            <td>{{ $template->type->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{$templates->render()}}
    </div>
@endsection
