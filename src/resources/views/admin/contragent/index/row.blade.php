<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-big"
                       href="{{ route('admin.contragents.show', $contragent) }}">{{ $contragent->name }}</a>
                    <a class="d-block text-muted"
                       href="{{ route('admin.users.show', $contragent->user) }}">{{ $contragent->user->name }}</a>
                </div>
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="mb-2 mb-md-0 text-muted">
                        <span class="d-block">@lang('site::contragent.inn'):
                            {{ $contragent->inn }}</span>
                        <span class="d-block">@lang('site::contragent.ogrn'):
                            {{ $contragent->ogrn }}</span>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xl-5">
                    <div class="mb-2 mb-md-0 text-secondary text-left text-md-right">
                        <div class="mb-1">@lang('site::contragent.organization_id'):
                            @if($contragent->organization)
                                {{$contragent->organization->name }}
                            @else
                                <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_f')</span>
                            @endif
                        </div>
                        <div>@lang('site::contragent.contract'):
                            @if($contragent->contract)
                                {{$contragent->contract }}
                            @else
                                <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_m')</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
