<tr>
    <td><a href="{{route('admin.equipments.show', $equipment)}}">{{ $equipment->name }}</a></td>
    <td>{{ $equipment->catalog->name }}</td>
    <td class="d-none d-sm-table-cell">
        @include('site::admin.equipment.images')
    </td>
    <td class="text-center">{{ $equipment->id }}</td>
</tr>