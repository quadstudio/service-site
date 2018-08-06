<ul>
    @foreach($element['equipments'] as $equipment)
        <li><a href="{{route('admin.equipments.show', ['id' => $equipment['id']])}}">{{$equipment['name']}}</a></li>
    @endforeach
</ul>