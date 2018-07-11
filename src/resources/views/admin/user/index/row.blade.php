<tr>
    <td class="text-center" style="width:40px;">
        @if($user->isOnline())
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.is_online')"
               class="fa fa-circle text-success"></i>
        @elseif(!$user->active)
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.activeOff')"
               class="fa fa-circle text-dark"></i>
        @endif
    </td>
    <td>
        @if(!$user->active)
            <del>
                @endif
                <a class="@if(!$user->active) text-muted @endif"
                   href="{{ route('admin.users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
                @if(!$user->active)
            </del>
        @endif
        ({{ $user->sc }})
        <small class="d-block text-muted">
            <b>@lang('site::user.created_at'):</b>
            {{ $user->created_at() }}
        </small>
        <small class="d-block text-muted">
            <b>@lang('site::user.logged_at'):</b>
            {{ $user->logged_at() }}
        </small>
    </td>
    {{--<td class="d-none d-sm-table-cell">{{ $user->sc }}</td>--}}
    <td class="d-none d-sm-table-cell">
        @if(!$user->addresses->isEmpty())
            {{ $user->addresses->where('type_id', 2)->first()->region->name }}
            &bull; {{ $user->addresses->where('type_id', 2)->first()->locality }}
        @endif
    </td>
    <td class="text-center d-none d-sm-table-cell">{{!empty($user->price_type) ? $user->price_type->name : '-'}}</td>
    <td class=" text-center">
        @if($user->verified)
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.verified')"
               class="fa fa-check text-success"></i>
        @else
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.activeOff')"
               class="fa fa-close text-danger"></i>
        @endif
    </td>
    <td class="text-center">
        @if($user->hasRole('asc'))
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.verified')"
               class="fa fa-check text-success"></i>
        @else
            <i data-toggle="tooltip" data-placement="top" title="@lang('site::user.is_asc')"
               class="fa fa-close text-danger"></i>
        @endif
    </td>

    <td class="text-center">{{ $user->id }}</td>
</tr>