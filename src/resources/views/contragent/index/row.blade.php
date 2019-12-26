<div class="items-col col-12">

    <div class="card mb-4">
        <div class="card-body">
            <div class="items-dropdown btn-group">
                <button type="button"
                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                        data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                     x-placement="bottom-end"
                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">
                    <a @can('edit', $contragent)
                       href="{{route('contragents.edit', $contragent)}}"
                       class="dropdown-item"
                       @else()
                       href="javascript:void(0);"
                       class="disabled dropdown-item"
                       @endcan>@lang('site::messages.edit')</a>
                    <button @cannot('delete', $contragent) disabled @endcannot class="dropdown-item btn-row-delete"
                            data-form="#contragent-delete-form-{{$contragent->id}}"
                            data-btn-delete="@lang('site::messages.delete')"
                            data-btn-cancel="@lang('site::messages.cancel')"
                            data-label="@lang('site::messages.delete_confirm')"
                            data-message="@lang('site::messages.delete_sure') @lang('site::contragent.contragent')? "
                            data-toggle="modal" data-target="#form-modal"
                            href="javascript:void(0);" title="@lang('site::messages.delete')">
                        @lang('site::messages.delete')
                    </button>
                    <form id="contragent-delete-form-{{$contragent->id}}"
                          action="{{route('contragents.destroy', $contragent)}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$contragent->type->name}}</div>
                    <h4 class="item-content-name mb-2">
                        <a href="{{route('contragents.show', $contragent)}}" class="text-dark">{{$contragent->name}}</a>
                    </h4>
                    <p>@lang('site::contragent.inn'): {{ $contragent->inn }}</p>
                    <hr class="border-light">
                    @php $address = $contragent->addresses()->whereTypeId(1)->first() @endphp
                    <div>
                        <div class="text-muted">{{$address->type->name}}: {{$address->full}}</div>
                        <div class="text-muted mr-3">@lang('site::contragent.organization_id')
                            : {{$contragent->organization->name}}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>