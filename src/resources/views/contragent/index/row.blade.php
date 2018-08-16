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

                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">@lang('site::contragent.header.legal')</h6>
                                <dl class="row">

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.inn')</dt>
                                    <dd class="col-sm-8">{{ $contragent->inn }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ogrn')</dt>
                                    <dd class="col-sm-8"> {{ $contragent->ogrn }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.kpp')</dt>
                                    <dd class="col-sm-8">{{ $contragent->kpp }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.okpo')</dt>
                                    <dd class="col-sm-8">{{ $contragent->okpo }}</dd>

                                </dl>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">@lang('site::contragent.header.payment')</h6>
                                <dl class="row">
                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.rs')</dt>
                                    <dd class="col-sm-8">{{ $contragent->rs }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bik')</dt>
                                    <dd class="col-sm-8"> {{ $contragent->bik }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.bank')</dt>
                                    <dd class="col-sm-8">{{ $contragent->bank }}</dd>

                                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contragent.ks')</dt>
                                    <dd class="col-sm-8">{{ $contragent->ks }}</dd>

                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                @php $address = $contragent->addresses()->whereTypeId(1)->first() @endphp
                                <h6 class="card-title">{{$address->type->name}}</h6>
                                <div class="item-content-about">
                                    <h5 class="item-content-name mb-1">
                                        <a href="javascript:void(0)" class="text-dark">{{$address->name}}</a>
                                    </h5>
                                    <hr class="border-light">
                                    <div>
                                        <img style="width: 30px;" class="img-fluid border"
                                             src="{{ asset($address->country->flag) }}"
                                             alt="">
                                        {{$address->country->name}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @php $address = $contragent->addresses()->whereTypeId(3)->first() @endphp
                                <h6 class="card-title">{{$address->type->name}}</h6>
                                <div class="item-content-about">
                                    <h5 class="item-content-name mb-1">
                                        <a href="javascript:void(0)" class="text-dark">{{$address->name}}</a>
                                    </h5>
                                    <hr class="border-light">
                                    <div>
                                        <img style="width: 30px;" class="img-fluid border"
                                             src="{{ asset($address->country->flag) }}"
                                             alt="">
                                        {{$address->country->name}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-light">
                    <div>
                        <div class="text-muted">@lang('site::contragent.nds') @bool(['bool' => $contragent->nds == 1])@endbool</div>
                        <div class="text-muted mr-3">@lang('site::contragent.organization_id')
                            : {{$contragent->organization->name}}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>