<tr>
    <td>{{$repair->created_at()}}</td>
    <td><a href="{{route('repairs.show', $repair)}}">{{$repair->number}}</a></td>
    <td class="text-right">{{$repair->cost_work()}}</td>
    <td class="text-right">{{ $repair->cost_road()}}</td>
    <td class="text-right">{{$repair->cost_parts()}}</td>
    <td class="text-center">{{$repair->status->name}}</td>
</tr>