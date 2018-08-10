<div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
    <img class="card-img-top" src="{{$image}}" alt="Card image">
    <div class="card-body text-left">
        <h4 class="card-title">{{$name}}</h4>
        <dl class="row">
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::product.sku')</dt>
            <dd class="col-12 col-md-6">{{$sku}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.cost')</dt>
            <dd class="col-12 col-md-6">{{$format}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.count')</dt>
            <dd class="col-12 col-md-6">
                <input name="parts[{{$product_id}}][count]"
                       placeholder="@lang('site::part.count')"
                       class="form-control parts_count"
                       type="number" min="1" max="3" maxlength="1" title=""
                       value="{{$count}}">
                <input type="hidden" name="parts[{{$product_id}}][product_id]"
                       value="{{$product_id}}">
                <input type="hidden" class="parts_cost" name="parts[{{$product_id}}][cost]"
                       value="{{$cost}}">
            </dd>
        </dl>
    </div>
</div>