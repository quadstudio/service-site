<button class="btn btn-success btn-row-delete"
        data-form="#create-digift-bonus"
        data-btn-delete="@lang('site::messages.yes')"
        data-btn-cancel="@lang('site::messages.no')"
        data-label="@lang('site::digift_bonus.button.create')"
        data-message="@lang('site::digift_bonus.button.confirmCreate')? "
        data-toggle="modal" data-target="#form-modal"
        href="javascript:void(0);">
    <i class="fa fa-plus"></i> @lang('site::digift_bonus.button.create')
</button>
<form id="create-digift-bonus"
      method="POST"
      action="{{$bonusable->bonusStoreRoute()}}">
    @csrf
</form>