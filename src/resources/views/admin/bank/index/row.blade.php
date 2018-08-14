<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-8 col-xl-9">
                    <a class="text-big" href="{{ route('admin.banks.show', $bank) }}">{{ $bank->name }}</a>
                    <div class="mb-2 mb-md-0 text-muted">
                        <span class="d-block">@lang('site::bank.id'):
                            {{ $bank->id }}</span>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="mb-2 mb-md-0 text-secondary text-left text-md-right">
                         <span class="d-block">{{$bank->city }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
