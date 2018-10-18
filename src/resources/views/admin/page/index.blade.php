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
            <li class="breadcrumb-item active">@lang('site::page.pages')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::page.icon')"></i> @lang('site::page.pages')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.pages.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::page.page')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-page d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $pages])@endpagination
        {{$pages->render()}}
        <div class="card mb-2">
            <div class="card-body">
                <table class="table table-sm ">
                    <thead>
                    <tr>
                        <th>@lang('site::page.h1')</th>
                        <th>@lang('site::page.title')</th>
                        <th>@lang('site::page.description')</th>
                        <th>@lang('site::page.route')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td><a href="{{route('admin.pages.show', $page)}}">{{$page->h1}}</a></td>
                            <td>{{$page->title}}</td>
                            <td>{!! $page->description !!}</td>
                            <td>{{$page->route}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{$pages->render()}}
    </div>
@endsection
