<div class="form-group" id="form-group-trade_id">
    <label class="control-label" for="trade_id">@lang('site::repair.trade_id')</label>
    @if($fails->contains('field', 'trade_id'))
        <span class="bg-danger text-white d-block d-sm-inline-block py-1 px-3 mb-1 mb-sm-0">@lang('site::messages.with_error')</span>
        <select data-form-action="{{ route('trades.create') }}"
                data-btn-ok="@lang('site::messages.save')"
                data-btn-cancel="@lang('site::messages.cancel')"
                data-label="@lang('site::messages.add') @lang('site::trade.trade')"
                class="dynamic-modal-form form-control{{  $errors->has('name') ? ' is-invalid' : '' }}"
                name="trade_id" id="trade_id">
            <option value="">@lang('site::repair.default.trade_id')</option>
            @foreach($trades as $trade)
                <option @if(old('trade_id', isset($repair) ? $repair->trade_id : null) == $trade->id) selected @endif
                value="{{ $trade->id }}">{{ $trade->name }}</option>
            @endforeach
            <option disabled value="">@lang('site::repair.help.trade_id')</option>
            <option value="load">✚ @lang('site::messages.add')</option>
        </select>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible mt-1">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p class="mb-0"><i class="icon mr-2 fa fa-check"></i> {!! session('success') !!}</p>
            </div>
        @endif
        <span class="invalid-feedback">{{ $errors->first('trade_id') }}</span>
    @elseif(isset($repair))
        <div class="text-success text-big">@if($repair->trade){{$repair->trade->name}}@endif</div>
    @endif
</div>
