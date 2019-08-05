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
            <li class="breadcrumb-item active">@lang('site::storehouse.storehouses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::storehouse.icon')"></i> @lang('site::storehouse.storehouses')
        </h1>
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('storehouses.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::storehouse.storehouse')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @alert()@endalert()
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $storehouses])@endpagination
        {{$storehouses->render()}}
        @foreach($storehouses as $storehouse)
            <div class="card my-2" id="storehouse-{{$storehouse->id}}">

                <div class="card-header with-elements">

                    <div class="card-header-elements">
                        <a href="{{route('storehouses.show', $storehouse)}}" class="mr-3 text-big">
                            {{$storehouse->name}}
                        </a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::storehouse.help.products')</dt>
                            @if($storehouse->uploaded_at)
                                <dd class="col-12">{{ $storehouse->products()->count() }}</dd>
                            @else
                                <dd class="col-12 text-danger">@lang('site::messages.no')</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">

                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::storehouse.uploaded_at')</dt>
                            @if($storehouse->uploaded_at)
                                <dd class="col-12">{{$storehouse->uploaded_at->format('d.m.Y H:i')}}</dd>
                            @else
                                <dd class="col-12 text-danger">@lang('site::messages.never')</dd>
                            @endif
                        </dl>

                    </div>

                    <div class="col-xl-4 col-sm-6">
                        @if($storehouse->addresses()->exists())
                            <dl class="dl-horizontal mt-2">
                                {{--<dt class="col-12">@lang('site::storehouse.help.addresses')</dt>--}}
                                <dd class="col-12">
                                    <div class="list-group"></div>
                                    @foreach($storehouse->addresses as $address)
                                        <a href="{{route('addresses.show', $address)}}"
                                           class="list-group-item list-group-item-action p-1">
                                            <i class="fa fa-@lang('site::address.icon')"></i> {{ $address->full }}
                                        </a>
                                    @endforeach
                                </dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::storehouse.enabled')
                                    <span>@bool(['bool' => $storehouse->enabled])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::storehouse.everyday')
                                    <span>@bool(['bool' => $storehouse->everyday])@endbool</span>
                            </dt>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$storehouses->render()}}
    </div>
@endsection
