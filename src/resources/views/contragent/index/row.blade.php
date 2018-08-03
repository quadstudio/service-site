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
                    <a class="disabled dropdown-item" href="javascript:void(0)">@lang('site::messages.edit')</a>
                    <a class="disabled dropdown-item" href="javascript:void(0)">@lang('site::messages.delete')</a>
                </div>
            </div>

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$contragent->type->name}}</div>
                    <h4 class="item-content-name mb-2">
                        <a href="javascript:void(0)" class="text-dark">{{$contragent->name}}</a>
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
                    <hr class="border-light">
                    <div>
                        <div class="text-muted">@lang('site::contragent.nds') @bool(['bool' => $contragent->nds == 1])@endbool</div>
                        <div class="text-muted mr-3">@lang('site::contragent.organization_id'): {{$contragent->organization->name}}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>