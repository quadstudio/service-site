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
            <li class="breadcrumb-item active">@lang('site::trade.trades')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::trade.icon')"></i> @lang('site::trade.trades')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $trades])@endpagination
        {{$trades->render()}}
        @foreach($trades as $trade)
            <div class="card my-2" id="trade-{{$trade->id}}">

                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::trade.name')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.trades.edit', $trade)}}" class="mr-3 text-big ml-0">
                                    {{$trade->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::trade.user_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.users.show', $trade->user)}}">
                                    {{$trade->user->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        @if($trade->address)
                            <dl class="dl-horizontal mt-0 mt-sm-2">
                                <dt class="col-12">@lang('site::trade.address')</dt>
                                <dd class="col-12">{{$trade->address}}</dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::trade.phone')</dt>
                            <dd class="col-12">
                                {{ $trade->country->phone }}{{ $trade->phone }}
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
        @endforeach
        {{$trades->render()}}

    </div>
@endsection
