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
            <li class="breadcrumb-item active">@lang('site::launch.launches')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $launches])@endpagination
        {{$launches->render()}}
        @foreach($launches as $launch)
            <div class="card my-2" id="launch-{{$launch->id}}">

                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::launch.name')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.launches.edit', $launch)}}" class="text-big mr-3 ml-0">
                                    {{$launch->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::launch.user_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.users.show', $launch->user)}}" class="mr-3 ml-0">
                                    {{$launch->user->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        @if($launch->address)
                            <dl class="dl-horizontal mt-0 mt-sm-2">
                                <dt class="col-12">@lang('site::launch.address')</dt>
                                <dd class="col-12">{{$launch->address}}</dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::launch.phone')</dt>
                            <dd class="col-12">
                                {{ $launch->country->phone }}{{ $launch->phone }}
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
        @endforeach
        {{$launches->render()}}

    </div>
@endsection
