@foreach($value as $catalog_id => $element)
    <option value="{{ $catalog_id }}"
            @if(old('catalog_id') == $catalog_id || $catalog_id == $parent_catalog_id) selected @endif
            @if($element['model'] == 1) disabled style="background-color: #CFD8DC;" @endif
    >{!! str_repeat("&nbsp;&nbsp;&nbsp;", $level) !!}{{ $element['name'] }}</option>
    @if (!empty($element['children']))
        @include('equipment::admin.catalog.tree.create', ['value' => $element['children'], 'level' => $level + 1])
    @endif
@endforeach