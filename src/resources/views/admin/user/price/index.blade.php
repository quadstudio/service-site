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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::user_price.user_price')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::user_price.icon')"></i> @lang('site::user_price.user_price') {{$user->name}}
        </h1>

        @alert()@endalert()

        <div class="card mb-4">
            <div class="card-body">
                <form id="form-content" method="POST" action="{{ route('admin.users.prices.store', $user) }}">
                    @csrf
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            @foreach($price_types as $price_type)
                                <th style="cursor: pointer;" onclick="checkColumn('price-type-{{$loop->index}}', true)" data-price-type="{{$loop->index}}" class="text-center">{{$price_type->name}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product_types as $product_type)
                            @php $price_checked = false @endphp
                            @php $product_checked = false @endphp
                            @php $default_checked = false @endphp
                            <tr>
                                <td class="text-right">{{$product_type->name}}</td>
                                @foreach($price_types as $price_type)
                                    @if($user_prices
                                                   ->where('price_type_id', $price_type->id)
                                                   ->where('product_type_id', $product_type->id)
                                                   ->count() == 1)
                                        @php $price_checked = true @endphp
                                        @php $product_checked = false @endphp
                                    @else
                                        @php $price_checked = false @endphp
                                    @endif
                                    @if($price_type->id == $default_price_type && !$product_checked)
                                        @php $default_checked = true @endphp
                                    @endif
                                    <td class="text-center p-0">
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                   id="user-price-{{$loop->parent->index}}-{{$loop->index}}"
                                                   @if(!$product_checked && ($price_checked || $default_checked))
                                                   checked
                                                   @php $product_checked = true @endphp
                                                   @endif
                                                   value="{{$price_type->id}}"
                                                   name="user_price[{{$product_type->id}}]"
                                                   class="custom-control-input price-type-{{$loop->index}}">
                                            <label class="custom-control-label"
                                                   for="user-price-{{$loop->parent->index}}-{{$loop->index}}">&nbsp;</label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button form="form-content" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    let checkColumn = function(targetClassElements, checked) {
        let elements = document.getElementsByClassName(targetClassElements);
        for (i = 0; i < elements.length; i++) {
            elements[i].checked = checked;
        }
    };
</script>
@endpush