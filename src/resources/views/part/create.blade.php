<div class="list-group-item p-1 product-{{$product->id}}">
    <div class="row">
        <div class="col-xl-6 col-sm-12">
            <dl class="dl-horizontal mt-2">
                <dt class="col-12">@lang('site::product.name') (@lang('site::product.sku'))</dt>
                <dd class="col-12">{{$product->name}} ({{$product->sku}})</dd>
                <dt class="col-12">@lang('site::part.cost')</dt>
                <dd class="col-12">
                    {{$product->hasPrice ? number_format($product->repairPrice->value, 0, '.', ' ') : trans('site::price.error.price')}}
                    {{ auth()->user()->currency->symbol_right }}
                </dd>
            </dl>
        </div>
        <div class="col-xl-6 col-sm-12">
            <dl class="dl-horizontal mt-2">
                <dt class="col-12">@lang('site::part.count')</dt>
                <dd class="col-12">
                    <select name="count[{{$product->id}}]"
                            required
                            data-cost="{{ $product->hasPrice ? $product->repairPrice->value : 0}}"
                            title="@lang('site::part.count')"
                            class="form-control parts_count">
                        @foreach(range(1,4,1) as $range_count)
                            <option @if(old('count.'.$product->id, (isset($count) ? $count : null)) == $range_count) selected
                                    @endif value="{{ $range_count }}">{{ $range_count }}</option>
                        @endforeach
                    </select>
                </dd>
                <dt class="col-12"></dt>
                <dd class="col-12">
                    <button type="button" class="btn btn-danger btn-sm part-delete" data-id="{{$product->id}}"
                            data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> @lang('site::messages.delete')</span>
                    </button>
                </dd>
            </dl>
        </div>
    </div>
</div>
