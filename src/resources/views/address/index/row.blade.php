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
                    <a @can('edit', $address)
                       href="{{route('addresses.edit', $address)}}"
                       class="dropdown-item"
                       @else()
                       href="javascript:void(0);"
                       class="disabled dropdown-item"
                       @endcan>@lang('site::messages.edit')</a>
                    <button @cannot('delete', $address) disabled @endcannot
                    class="dropdown-item btn-row-delete"
                            data-form="#address-delete-form-{{$address->id}}"
                            data-btn-delete="@lang('site::messages.delete')"
                            data-btn-cancel="@lang('site::messages.cancel')"
                            data-label="@lang('site::messages.delete_confirm')"
                            data-message="@lang('site::messages.delete_sure') @lang('site::address.address')? "
                            data-toggle="modal" data-target="#form-modal"
                            href="javascript:void(0);" title="@lang('site::messages.delete')">
                        @lang('site::messages.delete')
                    </button>
                    <form id="address-delete-form-{{$address->id}}"
                          action="{{route('addresses.destroy', $address)}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$address->type->name}}</div>
                    <h5 class="item-content-name mb-1">
                        <a href="{{route('addresses.show', $address)}}"
                           class="text-dark">{{$address->name}}</a>
                    </h5>
                    <hr class="border-light">
                    <div>
                        <img style="width: 30px;" class="img-fluid border" src="{{ asset($address->country->flag) }}"
                             alt="">
                        {{$address->country->name}}
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>