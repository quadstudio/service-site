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
                <a href="{{ route('distributors.index') }}">@lang('site::order.distributors')</a>
            </li>
            <li class="breadcrumb-item active">№ {{ $order->id }}</li>
        </ol>
        <h1 class="header-title mb-4">№ {{ $order->id }}</h1>
        @alert()@endalert()

        <div class=" border p-3 mb-2">

            <a href="{{ route('distributors.excel', ['order' => $order]) }}"
               class="d-block d-sm-inline btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-primary">
                <i class="fa fa-download"></i>
                <span>@lang('site::messages.download') @lang('site::messages.to_excel')</span>
            </a>
            <a href="{{ route('distributors.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row mb-2">
            <div class="col-xl-4">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.info')</span>
                    </h6>
                    <div class="card-body">

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.created_at'):</span>&nbsp;
                            <span class="text-dark">{{$order->created_at->format('d.m.Y H:i' )}}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.status_id'):</span>&nbsp;
                            <span class="badge text-normal badge-pill text-white"
                                  style="background-color: {{ $order->status->color }}">
                                <i class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}
                            </span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.user_id'):</span>&nbsp;
                            <span class="text-dark">{{ $order->user->name }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.contragent_id'):</span>&nbsp;
                            <span class="text-dark">{{ $order->contragent->name }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::user.email'):</span>&nbsp;
                            <span class="text-dark">{{$order->user->email}}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.contacts_comment'):</span>&nbsp;
                            <span class="text-dark">{{$order->contacts_comment}}</span>
                        </div>

                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.address_id'):</span>&nbsp;
                            <span class="text-dark">{{ optional($order->address)->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">@lang('site::order.in_stock_type'):</span>&nbsp;
                            <span class="text-dark">@lang('site::order.help.in_stock_type.'.$order->in_stock_type)</span>
                        </div>

                        <hr class="p-0"/>

                        <div class="mb-2">
                            <div class="font-weight-bold mb-0">@lang('site::order.total'):</div>&nbsp;
                            <div class="text-dark display-6 font-weight-bolder">
                                @include('site::order.total')
                            </div>
                        </div>

                        <hr class="p-0"/>
                        <div class="mb-2">
                            <div class="font-weight-bold mb-0">@lang('site::order.help.payment')</div>&nbsp;
                            @if(in_array($order->status_id, array(1,2,3,4,5)))
                                <div class="form-row mt-2">
                                    <div class="col">

                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{route('distributors.payment', $order)}}">
                                            @csrf
                                            <input type="hidden"
                                                   name="type_id"
                                                   value="19"/>
                                            <input type="hidden"
                                                   name="storage"
                                                   value="payments"/>
                                            <input class="d-inline-block form-control-file{{ $errors->has('file_id') ? ' is-invalid' : '' }}"
                                                   type="file"
                                                   accept="{{config('site.payments.accept')}}"
                                                   name="path"/>

                                            <button type="submit"
                                                    class="py-0 px-1 btn-sm btn btn-ferroli file-upload-button">
                                                @lang('site::messages.attach')
                                            </button>
                                            <span class="invalid-feedback">{{ $errors->first('file_id') }}</span>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div id="files" class="form-row bg-white ml-2">
                                @include('site::admin.file.edit', ['delete' => in_array($order->status_id, array(1,2,3,4,5))])
                            </div>
                        </div>

                        <hr class="p-0"/>
                        <div>
                            <form action="{{route('distributors.update', $order)}}"
                                  method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex flex-column justify-content-between">
                                    @foreach(range(2,6) as $status_id)
                                        <button name="order[status_id]"
                                                value="{{$status_id}}"
                                                type="submit"
                                                class="btn @if($status_id == 6) btn-danger @else btn-secondary @endif mb-1">
                                            @lang('site::order.button.status.'.$status_id)
                                        </button>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::order.items')</span>
                    </h6>
                    <div class="card-body">
                        @foreach($order->items as $item)
                            <hr class="mb-3"/>
                            <div class="row mb-sm-1">

                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-3 d-none d-md-block">
                                            <img class="img-fluid img-thumbnail"
                                                 src="{{ $item->product->image()->src() }}">
                                        </div>
                                        <div class="col-sm-9">
                                            <a class="d-block"
                                               href="{{route('products.show', $item->product)}}">{!! $item->product->name() !!}</a>
                                            <div class="text-muted">
                                                {{ $item->quantity }} {{ $item->product->unit }} x
                                                {{Site::convert($item->price, $item->currency_id, $item->currency_id, 1, false, true)}}
                                                @if ($item->currency_id != 643)
                                                    ({{Site::convert($item->price, $item->currency_id, 643, 1, false, true)}}
                                                    )
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-4 mb-sm-0 text-large text-left text-sm-right">
                                    {{Site::convert($item->price, $item->currency_id, $item->currency_id, $item->quantity, false, true)}}
                                    @if ($item->currency_id != 643)
                                        ({{Site::convert(
                                            $item->price,
                                            $item->currency_id,
                                            643,
                                            $item->quantity,
                                            true,
                                            true)}})
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
                @include('site::message.create', ['messagable' => $order])
            </div>
        </div>
    </div>
@endsection
