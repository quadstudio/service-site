<div class="items-col col-12" id="address-{{$address->id}}">

    <div class="card mb-2">
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
                    <a href="{{route('admin.addresses.edit', $address)}}"
                       class="dropdown-item">@lang('site::messages.edit')</a>
                    <a href="{{route('admin.addresses.phones.create', $address)}}" class="dropdown-item">
                        @lang('site::messages.add') @lang('site::phone.phone')
                    </a>
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
                          action="{{route('admin.addresses.destroy', $address)}}"
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
                        <a href="{{route('admin.addresses.show', $address)}}">
                            <img style="width: 30px;" class="img-fluid border"
                                 src="{{ asset($address->country->flag) }}"
                                 alt="">
                            {{$address->full}}
                        </a>
                    </h5>
                    <div class="list-group">
                        @foreach($address->phones as $phone)
                            <a href="{{route('admin.phones.edit', $phone)}}"
                               class="list-group-item list-group-item-action">{{$phone->country->phone}} {{$phone->number}}</a>
                        @endforeach
                    </div>
                    <hr class="border-light">
                    <div>
                        @lang('site::address.name'): <b>{{$address->name}}</b><br />
                        @lang('site::address.web'): <b>{{$address->web}}</b><br />
			@lang('site::address.email'): <b>{{$address->email}}</b><br />
			@if(( $address->is_service ))<span class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Сервис</span> @endif
			@if(( $address->is_shop ))<span class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Торговая точка</span> @endif
			@if(( $address->is_eshop ))<span class="badge text-normal mb-0 mb-sm-1 badge-ferroli">Интернет-магазин</span> @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
