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
            <li class="breadcrumb-item active">@lang('site::announcement.announcements')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::announcement.icon')"></i> @lang('site::announcement.announcements')
        </h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.announcements.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::announcement.announcement')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $announcements])@endpagination
        {{$announcements->render()}}
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>

                        <th class="d-none d-md-table-cell"></th>
                        <th>@lang('site::announcement.title')</th>
                        <th class="text-center">@lang('site::announcement.date')</th>
                        <th class="d-none d-md-table-cell text-center">@lang('site::messages.created_at')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($announcements as $announcement)
                        <tr>
                            <td class="d-none d-md-table-cell text-center" style="width:80px!important;">
                                <img style="width:100%;" src="{{$announcement->image()->exists() ? $announcement->image->src() : Storage::disk($announcement->image->storage)->url($announcement->image->path)}}" alt="">
                            </td>
                            <td class="align-middle">
                                <a href="{{route('admin.announcements.show', $announcement)}}">{!! $announcement->title !!}</a>
                                <div>
                                    <span class="text-muted">@lang('site::messages.show_ferroli'):</span>
                                    @bool(['bool' => $announcement->show_ferroli == 1])@endbool
                                </div>
                                <div>
                                    <span class="text-muted">@lang('site::messages.show_lamborghini'):</span>
                                    @bool(['bool' => $announcement->show_lamborghini == 1])@endbool
                                </div>
                            </td>
                            <td class="align-middle text-center">{{$announcement->date->format('d.m.Y')}}</td>
                            <td class="align-middle d-none d-md-table-cell text-center">{{$announcement->created_at->format('d.m.Y H:i' )}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{$announcements->render()}}
    </div>
@endsection
