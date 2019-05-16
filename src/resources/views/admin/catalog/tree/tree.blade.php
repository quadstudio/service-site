@foreach($value as $catalog_id => $element)
    <ul @if($level == 0) class="tree" @endif>
        <li>
            <a class="list-group-item-action"
               href="{{route('admin.catalogs.show', $element['id'])}}">
                @if($element['enabled'])
                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::catalog.enabled')"
                       class="fa fa-check text-success"></i>
                @else
                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::catalog.enabled')"
                       class="fa fa-close text-danger"></i>
                @endif
                {!! $element['name'] !!}
            </a>

            @if($element['can']['addCatalog'])
                <div class="d-inline-block">
                    <a data-toggle="tooltip" data-placement="top" class="text-success"
                       title="@lang('site::messages.add') @lang('site::catalog.catalog')"
                       href="{{route('admin.catalogs.create.parent', $element['id'])}}">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-@lang('site::catalog.icon')"></i>
                    </a>
                </div>
            @endif
            @if($element['can']['addEquipment'])
                <div class="d-inline-block">
                    <a data-toggle="tooltip" data-placement="top" class="text-success"
                       title="@lang('site::messages.add') @lang('site::equipment.equipment')"
                       href="{{route('admin.equipments.create.parent', $element['id'])}}">
                        <i class="fa fa-plus"></i>
                        <i class="fa fa-@lang('site::equipment.icon')"></i>
                    </a>
                </div>
            @endif

            @if (!empty($element['children']))
                @include('site::admin.catalog.tree.tree', ['value' => $element['children'], 'level' => $level + 1])
            @endif
            @if (!empty($element['equipments']))
                @include('site::admin.catalog.tree.equipment', ['value' => $element['equipments']])
            @endif
        </li>
    </ul>
@endforeach