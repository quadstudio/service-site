@foreach($value as $catalog_id => $element)
    <ul @if($level == 0) class="tree" @endif>
        <li>
            <a class="list-group-item-action{{ $element['model'] ? ' text-danger' : '' }}"
               href="{{route('admin.catalogs.show', $element['id'])}}">
                {!! $element['name'] !!}
                @if($element['enabled'])
                    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.enabled')"
                       class="fa fa-check text-success"></i>
                @else
                    <i data-toggle="tooltip" data-placement="top" title="@lang('equipment::catalog.enabled')"
                       class="fa fa-close text-secondary"></i>
                @endif
            </a>

            @if($element['can']['addCatalog'])
                <div class="d-inline-block">
                    <a data-toggle="tooltip" data-placement="top" class="text-success"
                       title="@lang('equipment::messages.add') @lang('equipment::catalog.catalog')"
                       href="{{route('admin.catalogs.create.parent', $element['id'])}}">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-folder-open"></i>
                    </a>
                </div>
            @endif

            @if (!empty($element['children']))
                @include('equipment::admin.catalog.tree.tree', ['value' => $element['children'], 'level' => $level + 1])
            @endif
            @if (!empty($element['products']))
                @include('equipment::admin.catalog.tree.product', ['value' => $element['products']])
            @endif
        </li>
    </ul>
@endforeach