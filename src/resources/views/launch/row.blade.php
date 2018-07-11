<tr>
    <td>
        <img style="width: 30px;" class="img-fluid border" src="{{ asset($item->country->flag) }}" alt="">
    </td>
    <td>
        <a href="{{ route('launches.show', $item) }}">{{ $item->name }}</a>

    </td>
    <td class="d-none d-sm-table-cell">
        {{ $item->country->name }}
    </td>
    <td class="d-none d-sm-table-cell">{{ $item->country->phone }}{{ $item->phone }}</td>
    <td class="d-none d-md-table-cell">{{ $item->address }}</td>
    <td class="text-right">
        <a class="btn btn-link" data-toggle="tooltip" data-placement="top" title="@lang('repair::messages.edit')"
           href="{{ route('launches.edit', $item) }}">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
        @if($item->canDelete())
            <a class="btn btn-link text-danger btn-row-delete"
               data-form="#launch-delete-form-{{$item->id}}"
               data-btn-delete="@lang('repair::messages.delete')"
               data-btn-cancel="@lang('repair::messages.cancel')"
               data-label="@lang('repair::messages.delete_confirm')"
               data-message="@lang('repair::messages.delete_sure') {{ $item->name }}?"
               data-toggle="modal" data-target="#form-modal"
               href="javascript:void(0);" title="@lang('repair::messages.delete')"><i class="fa fa-close"></i>
            </a>
            <form id="launch-delete-form-{{$item->id}}"
                  action="{{route('launches.destroy', $item)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </td>
</tr>