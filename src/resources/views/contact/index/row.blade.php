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
                    <a class="disabled dropdown-item" href="javascript:void(0)">@lang('site::messages.edit')</a>
                    <a class="disabled dropdown-item" href="javascript:void(0)">@lang('site::messages.delete')</a>
                </div>
            </div>

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$contact->type->name}}</div>
                    <h5 class="item-content-name mb-1">
                        <a href="javascript:void(0)" class="text-dark">{{$contact->name}}</a>
                    </h5>

                    @if($contact->position)
                        <div class="small">
                            {{$contact->position}}
                        </div>
                    @endif

                    @if(!$contact->phones->isEmpty())
                        <hr class="border-light">
                        <div>
                            @foreach($contact->phones as $phone)
                                <span class="text-secondary mr-3">{{$phone->country->phone}}{{$phone->number}}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>