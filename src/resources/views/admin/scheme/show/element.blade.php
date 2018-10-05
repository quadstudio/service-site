<tr class="sort-item" data-id="{{$element->id}}">
    <td class="p-1 width-10 ">{{$element->number}}</td>
    <td class="p-1">
        <div class="custom-control custom-checkbox">
            <input type="checkbox"
                   name="elements[]"
                   value="{{$element->id}}"
                   class="custom-control-input"
                   id="element-{{$element->id}}">
            <label class="custom-control-label" for="element-{{$element->id}}">{!! $element->product->name !!}</label>
        </div>
    </td>
    <td class="p-1 width-10 align-middle text-center"><i class="fa fa-arrows"></i></td>
</tr>