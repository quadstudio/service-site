<tr>
    <td>
        <a class="d-block text-big" href="{{route('admin.members.show', $member)}}">{{$member->name}}</a>
    </td>
    <td>{{$member->type->name}}</td>
    <td>
        <div>@lang('site::messages.date_from')&nbsp;&nbsp;&nbsp;{{$member->date_from->format('d.m.Y')}}</div>
        <div>@lang('site::messages.date_to')&nbsp;{{$member->date_to->format('d.m.Y')}}</div>
    </td>
    <td>{{$member->event->title}}</td>

    <td>
        <div><i class="fa fa-user"></i> {{$member->contact}}</div>
        <div><i class="fa fa-phone"></i> {{$member->country->phone}} {{$member->phone}}</div>
        <div class="@if($member->verified == 0) text-danger @else text-success @endif">{{$member->email}}</div>
    </td>

    <td>{{$member->region->name}}</td>
    <td>{{$member->city}}</td>
    <td class="text-center">{{$member->count}}</td>
    <td class="text-center">{{$member->status->name}}</td>

</tr>