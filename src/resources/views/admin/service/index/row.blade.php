<tr>
    <td class="text-center" style="width:40px;">
        @if($service->user->isOnline())
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.is_online')"
               class="fa fa-circle text-success"></i>
        @elseif(!$service->user->active)
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.activeOff')"
               class="fa fa-circle text-dark"></i>
        @endif
    </td>
    <td>
        <a href="{{ route('admin.users.show', $service->user) }}">{{ $service->user->name }}</a>
    </td>
    <td>
        <a href="{{ route('admin.services.show', $service) }}">{{ $service->name }}</a>
    </td>
    <td>{{ $service->user->addresses->where('type_id', 2)->first()->region->name }} / {{ $service->user->addresses->where('type_id', 2)->first()->locality }}</td>
    <td class="d-none d-sm-table-cell">{{ $service->user->logged_at() }}</td>
    <td>{{ $service->id }}</td>
</tr>