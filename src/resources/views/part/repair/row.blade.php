<tr>
    <td class="text-center">{{$sku}}</td>
    <td>{{$name}}</td>
    <td class="text-right">{{$format}}</td>
    <td class="text-center">
        <input type="hidden" name="parts[{{$product_id}}][product_id]"
               value="{{$product_id}}">
        <input type="hidden" class="parts_cost" name="parts[{{$product_id}}][cost]"
               value="{{$cost}}">
        <input name="parts[{{$product_id}}][count]"
               placeholder="@lang('site::part.count')"
               class="form-control parts_count"
               type="number" min="1" max="5" maxlength="1" title=""
               value="{{$count}}">
    </td>
</tr>