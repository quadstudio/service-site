<div class="items-col col-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="items-dropdown btn-group">
                <button type="button"
                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                        data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                     x-placement="bottom-end"
                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">
                    <a class="dropdown-item"
                       href="{{ route('trades.edit', $trade) }}">@lang('site::messages.edit')</a>
                    @if($trade->canDelete())
                        <a class="dropdown-item btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#trade-delete-form-{{$trade->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $trade->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal"
                        >@lang('site::messages.delete')</a>
                        <form id="trade-delete-form-{{$trade->id}}"
                              action="{{route('trades.destroy', $trade)}}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
            <div class="item-content">
                <div class="item-content-about">
                    <h5 class="item-content-name mb-1">
                        <a href="{{ route('trades.show', $trade) }}" class="text-dark">{{$trade->name}}</a>
                    </h5>
                    <div class="item-content-user text-muted mb-2">@lang('site::trade.address')
                        : {{$trade->address}}</div>
                    <div class="item-content-user text-muted small mb-2">
                        <img style="width: 30px;" class="img-fluid border" src="{{ asset($trade->country->flag) }}"
                             alt="">
                        {{ $trade->country->name }}
                    </div>
                    <hr class="border-light">
                    <div>
                        <span class="text-secondary mr-3">{{$trade->country->phone}}{{$trade->phone}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>