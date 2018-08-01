<div class="modal fade" id="confirm-add-to-cart" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">@lang('site::cart.add_add')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site::cart.add_form_cancel')</button>
                <a href="{{route('cart')}}" class="btn btn-primary btn-ok">@lang('site::cart.add_form_ok')</a>
            </div>
        </div>
    </div>
</div>