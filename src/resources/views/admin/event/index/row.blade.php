<tr>
    <td class="text-center p-1 pt-3" style="width:100px!important;">
        <img style="width:100%;" src="{{$event->image->src()}}" alt="">
    </td>
    <td>
        <a class="d-block text-large my-1"
           href="{{ route('admin.events.show', $event) }}">{{ $event->title }}</a>
        <small class="px-1 d-inline-block
        @if($event->status_id == 1) text-primary @endif
        @if($event->status_id == 2) text-success @endif
        @if($event->status_id == 3) text-secondary @endif ">{{$event->type->name}} - {{$event->status->name}}
        </small>
    </td>
    <td class="text-center">
        <div class="px-1 @if($event->confirmed == 1) bg-success text-white @endif">{{$event->date_from()}}</div>
    </td>
    <td class="text-center">
        <div class="px-1 @if($event->confirmed == 1) bg-success text-white @endif">{{$event->date_to()}}</div>
    </td>
    <td>{{$event->region->name}}</td>
    <td>{{$event->city}}@if($event->hasAddress()), {{$event->address}} @endif </td>

    <td class="text-center">{{$event->members()->count()}}</td>
</tr>