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
            <li class="breadcrumb-item active">@lang('site::news.news')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::news.icon')"></i> @lang('site::news.news')
        </h1>
        @alert()@endalert

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.news.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::news.new')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $news])@endpagination
        {{$news->render()}}
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>

                        <th></th>
                        <th>@lang('site::news.title')</th>
                        <th class="text-center">@lang('site::news.published')</th>
                        <th class="text-center">@lang('site::news.date')</th>
                        <th class="d-none d-md-table-cell text-center">@lang('site::news.created_at')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $item)
                        <tr>
                            <td class="text-center" style="width:80px!important;">
                                <img style="width:100%;" src="{{$item->image()->exists() ? $item->image->src() : Storage::disk($item->image->storage)->url($item->image->path)}}" alt="">
                            </td>
                            <td class="align-middle"><a href="{{route('admin.news.show', $item)}}">{!! $item->title !!}</a></td>
                            <td class="align-middle text-center">@bool(['bool' => $item->published == 1])@endbool</td>
                            <td class="align-middle text-center">{{$item->date->format('d.m.Y')}}</td>
                            <td class="align-middle d-none d-md-table-cell text-center">{{$item->created_at->format('d.m.Y H:i' )}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{$news->render()}}
    </div>
@endsection
