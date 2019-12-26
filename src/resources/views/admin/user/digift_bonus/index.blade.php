<div class="card mb-2" id="user-digift-bonuses">
    <div class="card-body">
        <h5 class="card-title">@lang('site::digift_user.header.digift_bonuses')</h5>
        @alert()@endalert()

        <div class="row">
            <div class="col text-center font-weight-bold">@lang('site::digift_user.header.accrued')</div>
            <div class="col text-center font-weight-bold">@lang('site::digift_user.header.send')</div>
            <div class="col text-center font-weight-bold">@lang('site::digift_user.header.paid')</div>
        </div>
        <div class="row">
            <div class="col text-center">{{$digiftUser->accruedDigiftBonusesSum}}</div>
            <div class="col text-center">{{$digiftUser->sendedDigiftBonusesSum}}</div>
            <div class="col text-center">{{$digiftUser->digiftExpensesSum}}</div>
        </div>
        <div class="row mt-3">
            <div class="col text-center">
                @if($digiftUser->accruedDigiftBonusesSum > 0)
                    <button @cannot('rollbackBalanceChange', $digiftUser) disabled @endcannot
                    class="btn btn-danger btn-row-delete"
                            data-form="#rollbackBalanceChange"
                            data-btn-delete="@lang('site::messages.yes')"
                            data-btn-cancel="@lang('site::messages.no')"
                            data-label="@lang('site::digift_user.button.cancel_all_charges')"
                            data-message="@lang('site::digift_user.button.confirm') {!! $user->name !!}? "
                            data-toggle="modal" data-target="#form-modal"
                            href="javascript:void(0);"
                            title="@lang('site::messages.delete')">
                        <i class="fa fa-close"></i> @lang('site::digift_user.button.cancel_all_charges')
                    </button>
                @endif
                <button @cannot('refreshToken', $digiftUser) disabled @endcannot
                class="btn btn-info btn-row-delete"
                        data-form="#refreshToken"
                        data-btn-delete="@lang('site::messages.yes')"
                        data-btn-cancel="@lang('site::messages.no')"
                        data-label="@lang('site::digift_user.button.refreshToken')"
                        data-message="@lang('site::digift_user.button.confirmRefreshToken')? "
                        data-toggle="modal" data-target="#form-modal"
                        href="javascript:void(0);">
                    <i class="fa fa-refresh"></i> @lang('site::digift_user.button.refreshToken')
                </button>

                @if($digiftUser->accruedDigiftBonusesSum > 0)
                    <form id="rollbackBalanceChange"
                          method="POST"
                          action="{{route('admin.digift.users.rollbackBalanceChange', $digiftUser)}}">
                        @method('DELETE')
                        @csrf
                    </form>

                @endif
                @can('refreshToken', $digiftUser)
                    <form id="refreshToken"
                          method="POST"
                          action="{{route('admin.digift.users.refreshToken',  $digiftUser)}}">
                        @method('PATCH')
                        @csrf
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>