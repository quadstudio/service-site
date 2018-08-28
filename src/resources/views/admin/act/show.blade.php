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
                <a href="{{ route('admin.acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item active">№ {{$act->id}}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::act.header.act') № {{$act->id}}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">
            {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"--}}
            {{--href="{{ route('admin.acts.create') }}"--}}
            {{--role="button">--}}
            {{--<i class="fa fa-magic"></i>--}}
            {{--<span>@lang('site::messages.create') @lang('site::act.act')</span>--}}
            {{--</a>--}}
            <a href="{{ route('admin.acts.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::act.help.back_list')</span>
            </a>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::act.created_at')</dt>
                    <dd class="col-sm-8">{{\Carbon\Carbon::instance($act->created_at)->format('d.m.Y H:i' )}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::act.user_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.users.show', $act->user)}}">{{ $act->user->name }}</a>
                        <div class="text-muted">{{ $act->user->address()->region->name }}
                            / {{ $act->user->address()->locality }}</div>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::act.received')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $act->received])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::act.number')</dt>
                    <dd class="col-sm-8">{{ $act->number }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_distance')</dt>
                    <dd class="col-sm-8">{{ Site::format($act->distanceCost) }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_difficulty')</dt>
                    <dd class="col-sm-8">{{ Site::format($act->difficultyCost) }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                    <dd class="col-sm-8">{{ Site::format($act->costParts) }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right border-top">@lang('site::act.help.total')</dt>
                    <dd class="col-sm-8 border-sm-top border-top-0">{{ Site::format($act->total) }}</dd>

                </dl>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">@lang('site::repair.repairs')</h5>
                @foreach($act->repairs as $repair)
                    <div class="row border-bottom">
                        <div class="col"><a href="{{route('admin.repairs.show', $repair)}}">{{$repair->id}}</a></div>
                        <div class="col">{{\Carbon\Carbon::instance(\DateTime::createFromFormat('Y-m-d', $repair->date_repair))->format('d.m.Y')}}</div>
                        <div class="col">
                            <a href="{{route('admin.products.show', $repair->product)}}">{{$repair->product->name}}</a>
                        </div>
                        <div class="col">
                            {{Site::format($repair->totalCost)}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <h5 class="card-title">@lang('site::act.header.detail_1')</h5>
                @php $detail = $act->details()->whereOur(1)->first() @endphp
                @include('site::admin.act.show.detail')
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">

                <h5 class="card-title">@lang('site::act.header.detail_0')</h5>
                @php $detail = $act->details()->whereOur(0)->first() @endphp
                @include('site::admin.act.show.detail')
            </div>
        </div>
    </div>
@endsection
