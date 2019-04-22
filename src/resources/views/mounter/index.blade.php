@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::mounter.mounters')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::mounter.icon')"></i> @lang('site::mounter.mounters')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('home') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $mounters])@endpagination
        {{$mounters->render()}}
        @foreach($mounters as $mounter)
            <div class="card my-4" id="mounter-{{$mounter->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">

                        <span class="badge text-normal badge-pill badge-{{ $mounter->status->color }} mr-3 ml-0">
                            <i class="fa fa-{{ $mounter->status->icon }}"></i> {{ $mounter->status->name }}
                        </span>
                        <a href="{{route('mounters.show', $mounter)}}" class="mr-3 ml-0">
                            @lang('site::mounter.header.mounter') № {{$mounter->id}}
                        </a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::messages.created_at')</dt>
                            <dd class="col-12">{{$mounter->created_at->format('d.m.Y')}}</dd>
                            <dt class="col-12">@lang('site::mounter.mounter_at')</dt>
                            <dd class="col-12">{{$mounter->mounter_at->format('d.m.Y')}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounter.user_address_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.addresses.show', $mounter->userAddress)}}">
                                    {{$mounter->userAddress->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounter.client')</dt>
                            <dd class="col-12">{{$mounter->client}}</dd>

                            @if($mounter->comment)
                                <dt class="col-12">@lang('site::mounter.comment')</dt>
                                <dd class="col-12">{{$mounter->comment}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounter.address')</dt>
                            <dd class="col-12">{{$mounter->address}}</dd>
                            <dt class="col-12">@lang('site::mounter.model')</dt>
                            <dd class="col-12">{{$mounter->model}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$mounters->render()}}
    </div>
@endsection
