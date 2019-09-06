<h4 class="text-danger">@lang('site::messages.has_error')</h4>
<form method="POST" action="{{route('storehouses.url.load', request()->route('storehouse'))}}">
    @csrf
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <td class="text-left text-dark">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           checked
                           class="custom-control-input"
                           id="check-all"
                           name="check_all">
                    <label class="custom-control-label" for="check-all">
                        @lang('site::messages.mark')
                        @lang('site::messages.all')
                    </label>
                </div>
            </td>
            <td class="text-center text-dark">@lang('site::storehouse_product.product_id')</td>
            <td class="text-center text-dark">@lang('site::storehouse_product.quantity')</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $id => $rows)
            <tr title="{{$id}}">
                <td class="text-left @if(isset($errors[$id])) text-danger @else text-success @endif">
                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox"
                               @if(isset($errors[$id]))
                               disabled
                               @else
                               checked
                               @endif
                               class="custom-control-input storehouse-product-check @if(isset($errors[$id])) disabled @endif"
                               id="check-{{$id}}"
                               value="{{$rows['quantity']}}"
                               name="check[{{$products[$id]['product_id']}}]">

                        <label class="custom-control-label" for="check-{{$id}}">{{$products[$id]['name']}}</label>
                    </div>
                </td>
                @foreach($rows as $c => $col)
                    @if(isset($errors[$id][$c]))
                        <td data-toggle="tooltip" data-placement="top" title=""
                            class="text-center text-big text-white bg-danger">
                            {{$col}} ({{$errors[$id][$c]}})
                        </td>
                    @else
                        <td class="text-center text-big text-success">
                            {{$col}}
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="text-center">
                <button class="btn btn-ferroli" type="submit">@lang('site::storehouse_product.button.load')</button>
            </td>
        </tr>
        </tfoot>
    </table>
</form>
