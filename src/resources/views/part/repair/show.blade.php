<div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
    <div class="card-body text-left">
        <h4 class="card-title">{{$name}}</h4>
        <dl class="row">
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::product.sku')</dt>
            <dd class="col-12 col-md-6">{{$sku}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.cost')</dt>
            <dd class="col-12 col-md-6">{{$format}}</dd>
            <dt class="col-12 col-md-6 text-left text-md-right">@lang('site::part.count')</dt>
            <dd class="col-12 col-md-6">{{$count}}</dd>
        </dl>
    </div>
</div>