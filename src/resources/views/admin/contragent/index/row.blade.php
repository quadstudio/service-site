<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-big" href="{{ route('admin.contragents.show', $contragent) }}">{{ $contragent->name }}</a>
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
                        <div>@lang('site::contragent.organization_id'):
                            {{$contragent->organization->name }}</div>
                        <div>@lang('site::contragent.contract'):
                            @if(is_null($contragent->contract))
                                <span class="badge text-normal badge-danger">Не указан</span>
                            @else
                                {{$contragent->contract }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
