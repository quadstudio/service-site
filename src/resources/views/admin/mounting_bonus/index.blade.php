@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::mounting_bonus.mounting_bonuses')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::mounting_bonus.icon')"></i> @lang('site::mounting_bonus.mounting_bonuses')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.mounting-bonuses.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::mounting_bonus.mounting_bonus')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $mounting_bonuses])@endpagination
        {{$mounting_bonuses->render()}}

        @foreach($mounting_bonuses as $mounting_bonus)
            <div class="card my-0" id="mounting-{{$mounting_bonus->id}}">

                <div class="row">
                    <div class="col-sm-4">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting_bonus.product_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.products.show', $mounting_bonus->product)}}">
                                    {{$mounting_bonus->product->name}} ({{$mounting_bonus->product->sku}})
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-sm-4">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting_bonus.value')</dt>
                            <dd class="col-12">
                                {{number_format($mounting_bonus->value, 0, '.', ' ')}}
                                {{ auth()->user()->currency->symbol_right }}

                            </dd>
                        </dl>
                    </div>
                    <div class="col-sm-4">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::mounting_bonus.social')</dt>
                            <dd class="col-12">
                                {{number_format($mounting_bonus->social, 0, '.', ' ')}}
                                {{ auth()->user()->currency->symbol_right }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$mounting_bonuses->render()}}
    </div>
@endsection
