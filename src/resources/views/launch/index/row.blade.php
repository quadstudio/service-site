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
                       href="{{ route('launches.edit', $launch) }}">@lang('site::messages.edit')</a>
                    @if($launch->canDelete())
                        <a class="dropdown-item btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#launch-delete-form-{{$launch->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $launch->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal"
                        >@lang('site::messages.delete')</a>
                        <form id="launch-delete-form-{{$launch->id}}"
                              action="{{route('launches.destroy', $launch)}}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
            <div class="item-content">
                <div class="item-content-about">
                    <h4 class="item-content-name mb-1">
                        <a href="{{ route('launches.show', $launch) }}" class="text-dark">{{$launch->name}}</a>
                    </h4>
                    <hr class="border-light">

                    <div class="item-content-user text-muted mb-2">
                        <img style="width: 30px;" class="img-fluid border" src="{{ asset($launch->country->flag) }}"
                             alt="">
                        {{ $launch->country->name }} {{$launch->address}}
                    </div>
                    <dl class="row">

                        <dt class="col-sm-4">@lang('site::launch.document_name')</dt>
                        <dd class="col-sm-8">{{$launch->document_name}}</dd>

                        <dt class="col-sm-4">@lang('site::launch.document_number')</dt>
                        <dd class="col-sm-8">{{$launch->document_number}}</dd>

                        <dt class="col-sm-4">@lang('site::launch.document_who')</dt>
                        <dd class="col-sm-8">{{$launch->document_name}}</dd>

                        <dt class="col-sm-4">@lang('site::launch.document_date')</dt>
                        <dd class="col-sm-8">{{$launch->document_date()}}</dd>

                    </dl>
                    <hr class="border-light">
                    <div>
                        <span class="text-secondary mr-3">{{$launch->country->phone}}{{$launch->phone}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>