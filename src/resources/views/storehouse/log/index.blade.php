@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storehouses.index') }}">@lang('site::storehouse.storehouses')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storehouses.show', $storehouse) }}">{{$storehouse->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::storehouse_log.storehouse_logs')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::storehouse_log.icon')"></i> @lang('site::storehouse_log.storehouse_logs')
        </h1>
        <div class=" border p-3 mb-2">
            <a href="{{ route('storehouses.show', $storehouse) }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::storehouse.help.back')</span>
            </a>
        </div>
        @alert()@endalert()
        @filter(['repository' => $repository, 'route_param' => $storehouse])@endfilter
        @pagination(['pagination' => $storehouse_logs])@endpagination
        {{$storehouse_logs->render()}}
        @foreach($storehouse_logs as $storehouse_log)
            <div class="card my-2" id="storehouse-{{$storehouse_log->id}}">
                <div class="row">
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::messages.date')</dt>
                            <dd class="col-12">{{$storehouse_log->created_at->format('d.m.Y H:i')}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::storehouse_log.url')</dt>
                            <dd class="col-12"><code>{{$storehouse_log->url}}</code></dd>
                        </dl>
                    </div>
                    <div class="col-xl-7 col-sm-12 p-2">
                        <ul>
                            @foreach($storehouse_log->message as $message)
                                <li>&bull;&nbsp;{{$message}}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        @endforeach
        {{$storehouse_logs->render()}}
    </div>
@endsection
