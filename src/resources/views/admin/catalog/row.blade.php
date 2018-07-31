<tr>
    <td class="text-center align-middle">
        @include('site::admin.catalog.field.enabled')
    </td>
    <td class="align-middle">
        <a class="" href="{{ route('admin.catalogs.show', $catalog) }}">{{ $catalog->name }}</a>
    </td>
    <td class="align-middle d-none d-sm-table-cell">
        @if(!is_null($catalog->catalog))
            {{ $catalog->catalog->name }}
        @endif
    </td>

    <td class="text-right">
        <a class="btn btn-link" data-toggle="tooltip" data-placement="top" title="@lang('site::messages.edit')"
           href="{{ route('admin.catalogs.edit', $catalog) }}">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </a>
        @if($catalog->canAddCatalog())
            <a class="btn btn-link" data-toggle="tooltip" data-placement="top"
               title="@lang('site::messages.add') @lang('site::catalog.catalog')"
               href="{{ route('admin.catalogs.create.parent', $catalog) }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        @endif
        @if($catalog->canDelete())
            <a class="btn btn-link text-danger btn-row-delete"
               data-form="#catalog-delete-form-{{$catalog->id}}"
               data-btn-delete="@lang('site::messages.delete')"
               data-btn-cancel="@lang('site::messages.cancel')"
               data-label="@lang('site::messages.delete_confirm')"
               data-message="@lang('site::messages.delete_sure') {{ $catalog->name }}?"
               data-toggle="modal" data-target="#form-modal"
               href="javascript:void(0);" title="@lang('site::messages.delete')"><i class="fa fa-close"></i>
            </a>
            <form id="catalog-delete-form-{{$catalog->id}}"
                  action="{{route('admin.catalogs.destroy', $catalog)}}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </td>
</tr>