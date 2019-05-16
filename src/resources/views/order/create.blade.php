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
                <a href="{{ route('orders.index') }}">@lang('site::order.orders')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-magic"></i> @lang('site::messages.create') @lang('site::order.order')</h1>

        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-danger d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('clearCart') }}"
               role="button">
                <i class="fa fa-close"></i>
                <span>@lang('site::cart.cart_clear')</span>
            </a>
            <a href="{{ route('cart') }}" class="d-block d-sm-inline btn btn-ferroli">
                <i class="fa fa-shopping-cart"></i>
                <span>@lang('site::cart.to_confirm_order')</span>
            </a>
        </div>

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4>Добавить товары по артикулу</h4>
                        <form class="product-button" data-name="" action="" method="post">
                            @csrf
                            <fieldset class="border p-3">
                                <div class="form-group required">
                                    <label class="control-label"
                                           for="fast_product_id">@lang('site::order_item.product_id')</label>
                                    <select data-limit="10" id="fast_product_id" style="width:100%"
                                            class="form-control">
                                        <option value=""></option>
                                    </select>
                                    <span id="fast_product_idHelp" class="d-block form-text text-success">
                                    @lang('site::order_item.help.product_id')
                                </span>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-6">
                        <h4>Загрузить из файла</h4>
                        <form enctype="multipart/form-data" action="{{route('orders.load')}}" method="post">
                            @csrf

                            <div class="form-row border p-3">
                                <div class="form-group mb-0">
                                    <label for="path">@lang('site::messages.xls_file')</label>
                                    <input type="file"
                                           name="path"
                                           accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                           class="form-control-file{{  $errors->has('path') ? ' is-invalid' : '' }}"
                                           id="path">
                                    {{--{{dump($errors)}}--}}
                                    <span class="invalid-feedback">{!! $errors->first('path') !!}</span>
                                    <button type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-download"></i>
                                        <span>@lang('site::messages.load')</span>
                                    </button>
                                    <span id="pathHelp" class="d-block form-text text-success">
                                            @lang('site::order.help.load') <br/> @lang('site::order.help.xlsexample')
                                        </span>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div id="cart-table">
                    @if(!Cart::isEmpty())
                        @include('site::cart.item.rows')
                    @endif
                </div>

                @include('site::cart.modal.delete')
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {
            let fast_product_id = $('#fast_product_id');
            fast_product_id.select2({
                theme: "bootstrap4",
                ajax: {
                    url: '{{route('api.products.fast')}}',
                    dataType: 'json',
                    delay: 200,
                    data: function (params) {
                        return {
                            'filter[search_part]': params.term,
                            'filter[limit]': fast_product_id.data('limit'),
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data.data,
                        };
                    }
                },
                minimumInputLength: 3,

                templateResult: function (product) {
                    if (product.loading) return "...";
                    let markup = "<img style='width:70px;' src=" + product.image + " /> &nbsp; " + product.name + ' (' + product.sku + ') - ' + product.format;
                    return markup;
                },
                templateSelection: function (product) {
                    return product.name;
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            fast_product_id.on('select2:select', function (e) {
                let product_id = $(this).find('option:selected').val();

                axios
                    .post(route('buy', product_id), {quantity: 1})
                    .then((response) => {
                        let parser = new Parser();
                        parser.parse(response.data);
                    })
                    .catch((error) => {
                        this.status = 'Error:' + error;
                    });
            });

        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush
