<li class="list-group-item" id="product-analog-{{$analog->id}}">
    <div class="media align-items-center">
        <div class="media-body px-2">
            <a href="{{route('admin.products.show', $analog)}}"
               class="text-dark">{{$analog->name()}}</a>
            <div class="btn-group dropleft pull-right">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-close"></i>
                </button>
                <div class="dropdown-menu">
                    <form class="px-4 py-3" id="product-analog-delete-form-{{$analog->id}}"
                          action="{{route('admin.analogs.destroy', [$product, $analog])}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="form-check">
                            <input type="checkbox" value="1" class="form-check-input" name="mirror"
                                   id="dropdownCheck-{{$analog->id}}">
                            <label class="form-check-label" for="dropdownCheck-{{$analog->id}}">
                                @lang('site::messages.mirror')
                            </label>
                        </div>
                    </form>
                    <a class="dropdown-item btn-row-delete"
                       data-form="#product-analog-delete-form-{{$analog->id}}"
                       data-btn-delete="@lang('site::messages.delete')"
                       data-btn-cancel="@lang('site::messages.cancel')"
                       data-label="@lang('site::messages.delete_confirm')"
                       data-message="@lang('site::messages.delete_sure') @lang('site::analog.analog') {{ $analog->name() }}?"
                       data-toggle="modal" data-target="#form-modal"
                       href="javascript:void(0);"
                       title="@lang('site::messages.delete')">@lang('site::messages.delete')</a>
                </div>
            </div>

        </div>
    </div>
</li>