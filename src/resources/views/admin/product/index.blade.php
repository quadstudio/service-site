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
            <li class="breadcrumb-item active">@lang('site::product.cards')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::product.icon')"></i> @lang('site::product.cards')</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $products])@endpagination
        {{$products->render()}}
        @foreach($products as $product)
            <div class="card my-4" id="product-{{$product->id}}">
                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.products.show', $product)}}" class="mr-3">
                            {{$product->name}} ({{$product->sku}})
                        </a>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        @component('site::components.bool.pill', ['bool' => $product->enabled])@endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-12">
                        @if($product->images()->exists())
                            <div class="row p-2">
                                <div class="col">@include('site::admin.image.preview', ['image' => $product->images()->orderBy('sort_order')->first()])</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-3 col-sm-12">
                        <dl class="dl-horizontal mt-sm-2">
                            <dt class="col-12">@lang('site::product.type_id')</dt>
                            <dd class="col-12">{{$product->type->name}}</dd>
                            <dt class="col-12">@lang('site::product.quantity')</dt>
                            <dd class="col-12">
                                 <span class="badge text-normal @if($product->quantity) badge-ferroli @else badge-light @endif">
                                    {{ $product->quantity }}
                                </span>
                            </dd>
                            @if($product->mounting_bonus)
                                <dt class="col-12">@lang('site::mounting_bonus.header.mounting_bonus')</dt>
                                <dd class="col-12">
                                    {{ $product->mounting_bonus->value }} + {{ $product->mounting_bonus->social }}
                                </dd>
                            @endif
                            @if($product->brand_id)
                                <dt class="col-12">@lang('site::product.brand_id')</dt>
                                <dd class="col-12">{{ $product->brand->name }}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-12">
                        <dl class="dl-horizontal mt-sm-2">
                            @foreach($product->prices()->typeEnabled()->get() as $price)
                                <dt class="col-12">{{$price->type->name}}</dt>
                                <dd class="col-12 mb-0">
                                    {{$price->price}} {{$price->currency->name}}
                                </dd>
                            @endforeach
                        </dl>
                    </div>

                    <div class="col-xl-3 col-sm-12">
                        <dl class="dl-horizontal mt-sm-2">
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::messages.show_ferroli')
                                <span>@bool(['bool' => $product->show_ferroli == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::messages.show_lamborghini')
                                <span>@bool(['bool' => $product->show_lamborghini == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::product.forsale')
                                <span>@bool(['bool' => $product->forsale == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::product.warranty')
                                <span>@bool(['bool' => $product->warranty == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::product.service')
                                <span>@bool(['bool' => $product->service == 1])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::image.images')
                                <span class="badge @if($product->images()->exists()) badge-ferroli @else badge-light @endif">
                                    {{$product->images()->count()}}
                                </span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::analog.analogs')
                                <span class="badge @if($product->analogs()->exists()) badge-ferroli @else badge-light @endif">
                                    {{$product->analogs()->count()}}
                                </span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::detail.details')
                                <span class="badge @if($product->details()->exists()) badge-ferroli @else badge-light @endif">
                                    {{$product->details()->count()}}
                                </span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::relation.relations')
                                <span class="badge @if($product->relations()->exists()) badge-ferroli @else badge-light @endif">
                                    {{$product->relations()->count()}}
                                </span>
                            </dt>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$products->render()}}
    </div>
@endsection
