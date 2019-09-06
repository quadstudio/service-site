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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.storehouses.index') }}">@lang('site::storehouse.storehouses')</a>
            </li>
            <li class="breadcrumb-item active">{{ $storehouse->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $storehouse->name }}</h1>
        <div class="justify-content-start border p-3 mb-2">
            <a class="@cannot('download', $storehouse) disabled @endcannot btn btn-primary d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.storehouses.show', [$storehouse, 'excel']) }}"
               role="button">
                <i class="fa fa-upload"></i>
                <span>@lang('site::storehouse.header.download')</span>
            </a>
            <a href="{{ route('admin.storehouses.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.user_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.users.show', $storehouse->user)}}">{{ $storehouse->user->name }}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.name')</dt>
                    <dd class="col-sm-8">{{ $storehouse->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $storehouse->enabled])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.everyday')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $storehouse->everyday])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.url')</dt>
                    <dd class="col-sm-8"><a href="{{ $storehouse->url }}">{{ $storehouse->url }}</a></dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.help.products')</dt>
                    @if($storehouse->uploaded_at)
                        <dd class="col-8">{{ $storehouse->products()->count() }}</dd>
                    @else
                        <dd class="col-8 text-danger">@lang('site::messages.no')</dd>
                    @endif

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.uploaded_at')</dt>
                    @if($storehouse->uploaded_at)
                        <dd class="col-8">{{$storehouse->uploaded_at->format('d.m.Y H:i')}}</dd>
                    @else
                        <dd class="col-8 text-danger">@lang('site::messages.never')</dd>
                    @endif
                </dl>
            </div>
        </div>
        @include('site::storehouse.products', compact('products', 'repository'))
    </div>
@endsection
