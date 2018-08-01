<tr>
    <td>
        <h4>{{$datasheet->file->name}}</h4>
        <small style="color:#999;">{{$datasheet->type->name}} {{$datasheet->date_from_to()}}</small>
        @if(!($products = $datasheet->products()->where('enabled', 1)->orderBy('equipment_id')->orderBy('name')->get())->isEmpty())
            <ul>
                @foreach($products as $product)
                    <li>{!! $product->name !!}</li>
                @endforeach
            </ul>
        @endif
    </td>
    <td class="text-right">
        <a href="{{ route('files.show', $datasheet->file) }}" class="btn btn-sm btn-success">
            @lang('site::messages.download')
        </a>
    </td>
</tr>