<li class="list-group-item p-1">
    <div class="row">
        <div class="col-xl-6 col-sm-12">
            <dl class="dl-horizontal mt-2">
                <dt class="col-12">@lang('site::product.name') (@lang('site::product.sku'))</dt>
                <dd class="col-12">{{$name}} ({{$sku}})</dd>
                <dt class="col-12">@lang('site::part.cost')</dt>
                <dd class="col-12">{{$format}}</dd>
            </dl>
        </div>
        <div class="col-xl-6 col-sm-12">
            <dl class="dl-horizontal mt-2">
                <dt class="col-12">@lang('site::part.count')</dt>
                <dd class="col-12">
                    <select name="parts[{{$product_id}}][count]"
                            required
                            title="@lang('site::part.count')"
                            class="form-control parts_count">
                        @foreach(range(1,4,1) as $count)
                            <option @if(old('parts.'.$product_id.'.count') == $count) selected
                                    @endif value="{{ $count }}">{{ $count }}</option>
                        @endforeach
                    </select>
                    {{--<input name="parts[{{$product_id}}][count]"--}}
                    {{--placeholder="@lang('site::part.count')"--}}
                    {{--class="form-control parts_count"--}}
                    {{--type="number" min="1" max="4" maxlength="1" title=""--}}
                    {{--value="{{$count}}">--}}
                    <input type="hidden"
                           name="parts[{{$product_id}}][product_id]"
                           value="{{$product_id}}">
                    <input type="hidden"
                           class="parts_cost"
                           name="parts[{{$product_id}}][cost]"
                           value="{{$cost}}">
                </dd>
                <dt class="col-12"></dt>
                <dd class="col-12">
                    <button type="button" class="btn btn-danger btn-sm part-delete" data-id="{{$product_id}}"
                            data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> @lang('site::messages.delete')</span>
                    </button>
                </dd>
            </dl>
        </div>
    </div>

</li>