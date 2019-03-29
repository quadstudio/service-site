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
                <a href="{{ route('admin.mountings.index') }}">@lang('site::mounting.mountings')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.mountings.show', $mounting) }}">№ {{$mounting->id}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') @lang('site::mounting.mounting')</h1>

        @alert()@endalert()
        <div class=" border p-3 mb-2">
            {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"--}}
            {{--href="{{ route('mountings.create') }}"--}}
            {{--role="button">--}}
            {{--<i class="fa fa-magic"></i>--}}
            {{--<span>@lang('site::messages.create') @lang('site::mounting.mounting')</span>--}}
            {{--</a>--}}
            <a href="{{ route('mountings.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col">


                {{-- КЛИЕНТ --}}
                <div class="card mt-2 mb-2">
                    <div class="card-body">
                        <form id="form-content"
                              method="POST"
                              enctype="multipart/form-data"
                              action="{{ route('mountings.store') }}">

                            @csrf
                            @method('PUT')
                            <div class="form-row required">
                                <label class="control-label"
                                       for="status_id">@lang('site::mounting.status_id')</label>
                                <select class="form-control{{  $errors->has('mounting.status_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="mounting[status_id]"
                                        id="status_id">
                                    @foreach($mounting_statuses as $mounting_status)
                                        <option
                                                @if(old('mounting.status_id', $mounting->status_id) == $mounting_status->id) selected
                                                @endif
                                                value="{{ $mounting_status->id }}">{{ $mounting_status->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('mounting.status_id') }}</span>
                            </div>
                        </form>
                        <hr/>
                        <div class="form-row">
                            <div class="col text-right">
                                <button form="form-content" type="submit"
                                        class="btn btn-ferroli mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('mountings.index') }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {
            let product_id = $('#product_id');
            product_id.select2({
                theme: "bootstrap4",
                selectOnClose: true,
                ajax: {
                    url: '/api/products/mounting',
                    delay: 250,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            'filter[search_part]': params.term,
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
                    let markup = product.type + ' ' + product.name + ' (' + product.sku + ')';
                    return markup;
                },
            });
            product_id.on('select2:select', function (e) {
                let data = e.params.data;
                //console.log(data);
                $('#product-name').html(data.name);
                $('#product-sku').html(data.sku);
                $('#product-bonus').html(data.bonus);
                $('#product-social-bonus').html(data.social_bonus);
                $('[name="mounting[product_id]"]').val(data.id);
            });
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush
