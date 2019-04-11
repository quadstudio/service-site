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
            <li class="breadcrumb-item active">@lang('site::order.orders')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')
        </h1>
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin') }}"
               class="d-block d-sm-inline btn btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.admin')</span>
            </a>
        </div>
        @alert()@endalert()
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $orders])@endpagination
        {{$orders->render()}}

        @foreach($orders as $order)
            <div class="card my-4" id="order-{{$order->id}}">

                <div class="card-header with-elements">
				
                    <div class="card-header-elements">
					    <a href="{{route('distributors.show', $order)}}" class="mr-3">
                            @lang('site::order.header.order') № {{$order->id}}
                        </a>
                        <span class="badge text-normal badge-pill badge-{{ $order->status->color }}">
                            <i class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}
                        </span>
                        
                    </div>

                    <div class="card-header-elements ml-md-auto">
					    <a href="{{route('admin.users.show', $order->user)}}">
                            <img id="user-logo" src="{{$order->user->logo}}" style="width:25px!important;height: 25px" class="rounded-circle mr-2">
                            {{$order->user->name}}
                        </a>
                        @if( $order->messages()->exists())
                            <span class="badge badge-secondary text-normal badge-pill">
                                <i class="fa fa-comment"></i> {{ $order->messages()->count() }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::messages.created_at')</dt>
                            <dd class="col-12">{{$order->created_at->format('d.m.Y H:i')}}</dd>

                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::order.address_id')</dt>
                            <dd class="col-12">{{ $order->address->name }}</dd>
                            {{--<dt class="col-12">@lang('site::order.user_id')</dt>--}}
                            {{--<dd class="col-12">--}}
                                {{--<img id="user-logo"--}}
                                     {{--src="{{$order->user->logo}}"--}}
                                     {{--style="width:25px!important;height: 25px"--}}
                                     {{--class="rounded-circle mr-2">{{$order->user->name}}--}}
                            {{--</dd>--}}
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::order.items')</dt>
                            <dd class="col-12">
                                <ul class="list-group"></ul>
                                @foreach($order->items()->with('product')->get() as $item)
                                    <li class="list-group-item border-0 px-0 py-1">
                                        <a href="{{route('products.show', $item->product)}}">
                                            {!!$item->product->name!!} ({{$item->product->sku}})
                                        </a>

                                        x {{$item->quantity}} {{$item->product->unit}}
                                    </li>
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::order.total')</dt>
                            <dd class="col-12">
                                {{number_format($order->total(), 0, '.', ' ')}}
                                {{ $order->user->currency->symbol_right }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$orders->render()}}
    </div>
@endsection
