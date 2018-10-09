<div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 alert alert-dismissible p-0">
    <div class="card-body text-left">
        <h4 class="card-title">{{$name}}</h4>
        <dl class="row">
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::product.sku')</dt>
            <dd class="col-12 col-md-6">{{$sku}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.cost')</dt>
            <dd class="col-12 col-md-6">{{$format}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.count')</dt>
            <dd class="col-12 col-md-6">
                <select name="parts[{{$product_id}}][count]"
                        required title="@lang('site::part.count')"
                        class="form-control parts_count">
                    @foreach([1,2,3,4] as $count)
                        <option @if(old('count') == $count) selected @endif value="{{ $count }}">{{ $count }}</option>
                    @endforeach
                </select>
                {{--<input name="parts[{{$product_id}}][count]"--}}
                       {{--placeholder="@lang('site::part.count')"--}}
                       {{--class="form-control parts_count"--}}
                       {{--type="number" min="1" max="4" maxlength="1" title=""--}}
                       {{--value="{{$count}}">--}}
                <input type="hidden" name="parts[{{$product_id}}][product_id]"
                       value="{{$product_id}}">
                <input type="hidden" class="parts_cost" name="parts[{{$product_id}}][cost]"
                       value="{{$cost}}">
            </dd>
        </dl>

    </div>
    <button type="button" class="close part-delete" data-id="{{$product_id}}" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>