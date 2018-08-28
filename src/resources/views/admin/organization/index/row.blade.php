<div class="col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <a class="text-big"
                       href="{{route('admin.organizations.show', $organization)}}">{{ $organization->name }}</a>
                    <div class="text-muted">{{ $organization->address }}</div>
                </div>
                <div class="col-12 col-sm-6">
                    <div>
                        @lang('site::organization.account_id'):
                        @if($organization->account)
                            {{$organization->account->id}}
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_m')</span>
                        @endif
                    </div>
                    <div>
                        @lang('site::account.bank_id'):
                        @if($organization->account && $organization->account->bank)
                            {{$organization->account->bank->name}}
                        @else
                            <span class="badge text-normal badge-danger">@lang('site::messages.not_indicated_m')</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
