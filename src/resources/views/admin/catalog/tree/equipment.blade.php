<ul>
    @foreach($element['equipments'] as $equipment)
        <li>
            <a href="{{route('admin.equipments.show', ['id' => $equipment['id']])}}">
                @if($equipment['enabled'])
                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::equipment.enabled')"
                       class="fa fa-check text-success"></i>
                @else
                    <i data-toggle="tooltip" data-placement="top" title="@lang('site::equipment.enabled')"
                       class="fa fa-close text-danger"></i>
                @endif
                {{$equipment['name']}}
            </a>
        </li>
    @endforeach
</ul>