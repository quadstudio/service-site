@foreach($value as $catalog_id => $element)
    <option value="{{ $catalog_id }}"
            @if(old('catalog.catalog_id', $catalog->catalog_id) == $catalog_id) selected @endif
            @if(isset($disabled) && $disabled == $catalog_id) disabled @endif
    >{!! str_repeat("&nbsp;&nbsp;&nbsp;", $level) !!}{{ $element['name'] }}</option>
    @if (!empty($element['children']))
        @include('site::admin.catalog.tree.edit', [
        'value' => $element['children'],
        'level' => $level + 1,
        'disabled' => (isset($disabled) ?$disabled : null)
        ])
    @endif
@endforeach