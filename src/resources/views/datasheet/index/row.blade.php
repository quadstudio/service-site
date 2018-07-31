<tr>
    <td>{{$datasheet->type->name}}</td>
    <td>{!! $datasheet->products->implode('name', "<br />")!!}</td>
    <td class="text-right"><a href="{{ route('files.show', $datasheet->file) }}"
           class="btn btn-sm btn-success">@lang('site::messages.download')</a></td>
</tr>