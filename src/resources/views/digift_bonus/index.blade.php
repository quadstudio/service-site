<div class="card mb-2" id="user-digift-bonuses">
    <div class="card-body">
        <h5 class="card-title">@lang('site::digift_user.header.digift_bonuses')</h5>
        @alert()@endalert()

        <div class="row">
            <div class="col text-center font-weight-bold">@lang('site::digift_user.header.accrued')</div>
            <div class="col text-center font-weight-bold">@lang('site::digift_user.header.paid')</div>
        </div>
        <div class="row">
            <div class="col text-center">{{$digiftUser->sendedDigiftBonuses->sum('operationValue')}}</div>
            <div class="col text-center">{{$digiftUser->digiftExpenses->sum('operationValue')}}</div>
        </div>
        @if($digiftUser->balance > 0)
            <div class="row mt-3">
                <div class="col text-center">
                    <button class="btn btn-success btn-row-delete"
                            data-form="#fullUrlToRedirect"
                            data-btn-delete="@lang('site::messages.yes')"
                            data-btn-cancel="@lang('site::messages.no')"
                            data-label="@lang('site::digift_user.button.fullUrlToRedirect')"
                            data-message="@lang('site::digift_user.button.confirmFullUrlToRedirect')? "
                            data-toggle="modal" data-target="#form-modal"
                            href="javascript:void(0);">
                        <i class="fa fa-rub"></i> @lang('site::digift_user.button.fullUrlToRedirect')
                    </button>
                    <form id="fullUrlToRedirect"
                          method="POST"
                          action="{{route('digift.users.fullUrlToRedirect', $digiftUser)}}">
                        @csrf
                    </form>
                </div>
            </div>
        @endif


    </div>
</div>
