<dl class="row">

    <dt class="col-sm-4 text-left text-sm-right">{{$bonusable->user->type->name}}</dt>
    <dd class="col-sm-8">
        <a href="{{route('admin.users.show', $bonusable->user)}}" class="mr-3 ml-0">
            {{$bonusable->user->name}}
        </a>
    </dd>

    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.created_at')</dt>
    <dd class="col-sm-8">
        {{ $bonusable->digiftBonus->created_at->format('d.m.Y H:i') }}
    </dd>

    <dt class="col-sm-4 text-left text-sm-right">@lang('site::digift_bonus.sended')</dt>
    <dd class="col-sm-8">@component('site::components.bool.yesno', ['bool' => $bonusable->digiftBonus->sended])@endcomponent</dd>

    <dt class="col-sm-4 text-left text-sm-right">@lang('site::digift_bonus.blocked')</dt>
    <dd class="col-sm-8">@component('site::components.bool.yesno', ['bool' => $bonusable->digiftBonus->blocked])@endcomponent</dd>

    <dt class="col-sm-4 text-left text-sm-right border-top">@lang('site::digift_bonus.operationValue')</dt>
    <dd class="col-sm-8 border-sm-top border-top-0">
        {{ $bonusable->digiftBonus->operationValue}}
        {{ $bonusable->user->currency->symbol_right }}
    </dd>
</dl>
@if($bonusable->digiftBonus->blocked == 0)
    <div class="row mt-3">
        <div class="col text-center">
            @can('send', $bonusable->digiftBonus)
                <button class="btn btn-success btn-row-delete"
                        data-form="#changeBalance"
                        data-btn-delete="@lang('site::messages.yes')"
                        data-btn-cancel="@lang('site::messages.no')"
                        data-label="@lang('site::digift_bonus.button.changeBalance')"
                        data-message="@lang('site::digift_bonus.button.confirmChangeBalance')? "
                        data-toggle="modal" data-target="#form-modal"
                        href="javascript:void(0);">
                    <i class="fa fa-send"></i> @lang('site::digift_bonus.button.changeBalance')
                </button>
            @endcan
            @can('block', $bonusable->digiftBonus)
                <button class="btn btn-danger btn-row-delete"
                        data-form="#rollbackBalanceChange"
                        data-btn-delete="@lang('site::messages.yes')"
                        data-btn-cancel="@lang('site::messages.no')"
                        data-label="@lang('site::digift_bonus.button.rollbackBalanceChange')"
                        data-message="@lang('site::digift_bonus.button.confirmRollback')? "
                        data-toggle="modal" data-target="#form-modal"
                        href="javascript:void(0);">
                    <i class="fa fa-close"></i> @lang('site::digift_bonus.button.rollbackBalanceChange')
                </button>
            @endcan
            @can('send', $bonusable->digiftBonus)
                <form id="changeBalance"
                      method="POST"
                      action="{{route('admin.digift.bonuses.changeBalance',  $bonusable->digiftBonus)}}">
                    @method('PATCH')
                    @csrf
                </form>
            @endcan
            @can('block', $bonusable->digiftBonus)
                <form id="rollbackBalanceChange"
                      method="POST"
                      action="{{route('admin.digift.bonuses.rollbackBalanceChange',  $bonusable->digiftBonus)}}">
                    @method('DELETE')
                    @csrf
                </form>
            @endcan
        </div>
    </div>
@endif