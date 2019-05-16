@foreach($value as $catalog_id => $element)
    <option value="{{ $catalog_id }}"
            @if(old('equipment.catalog_id') == $catalog_id || $catalog_id == $parent_catalog_id) selected @endif
    >{!! str_repeat("&nbsp;&nbsp;&nbsp;", $level) !!}{{ $element['name'] }}</option>
    @if (!empty($element['children']))
        @include('site::admin.catalog.tree.create', ['value' => $element['children'], 'level' => $level + 1])
    @endif
@endforeach