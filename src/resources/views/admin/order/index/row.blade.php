
<tr>
    <td class="text-center"><span>{{$item->id }}</span></td>
    <td class="text-center">
        <a href="{{ route('admin.orders.show', $item) }}"><span>{{ $item->created_at->format('d.m.Y H:i') }}</span></a>
    </td>
    <td class="d-none d-md-table-cell">
        <a href="{{ route('admin.users.show', $item->user) }}">{{$item->user->name }}</a>
    </td>
    <td class="text-right">{{ Site::cost($item->total()) }}</td>
    <td class="text-center">
         <span class="d-table-cell d-sm-none">
            <i style="color: {{ $item->status['color'] }};" data-toggle="tooltip" data-placement="top" title="{{ $item->status['name'] }}"
               class="fa fa-{{ $item->status['icon'] }}"></i>
        </span>
        <span style="color: {{ $item->status['color'] }};" class="badge d-none d-sm-table-cell">{{ $item->status['name'] }}</span>

    </td>
</tr>
