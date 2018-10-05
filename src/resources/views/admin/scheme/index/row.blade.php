<tr data-id="{{$scheme->id}}">
    <td><a class="" href="{{ route('admin.schemes.show', $scheme) }}">{{ $scheme->block->name }}</a></td>

    <td><a href="{{ route('admin.datasheets.show', $scheme->datasheet) }}">{{ $scheme->datasheet->file->name }}</a></td>
    <td class="text-center">{{ $scheme->elements()->count() }}</td>
    <td class="text-center">
        @if(($products = $scheme->datasheet->products)->isNotEmpty())
            <div class="list-group">
            @foreach($products as $product)
                <a class="p-1 list-group-item list-group-item-action" href="{{route('admin.products.show', $product)}}">{!! $product->name !!}</a>
            @endforeach
            </div>
        @endif
    </td>
    {{--<img class="img-thumbnail width-70" src="{{$scheme->image->src()}}">--}}
</tr>