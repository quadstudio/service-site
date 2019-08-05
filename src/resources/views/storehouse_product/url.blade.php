<h4 class="text-danger">Найдены ошибки</h4>
<table class="table table-bordered table-responsive table-sm">
    <thead>
    <tr>
        <td style="width: 49%;" class="text-center text-dark">@lang('site::storehouse_product.product_id')</td>
        <td style="width: 49%;" class="text-center text-dark">@lang('site::storehouse_product.quantity')</td>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $id => $rows)
        <tr title="{{$id}}">
            @foreach($rows as $c => $col)
                @if(isset($errors[$id][$c]))
                    <td data-toggle="tooltip" data-placement="top" title="{{$errors[$id][$c]}}"
                        class="text-center text-big text-white bg-danger">{{$col}}</td>
                @else
                    <td class="text-center text-big text-white bg-success">{{$col}}</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>