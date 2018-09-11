<div class="items-col col-12 sort-item" id="difficulty-{{$difficulty->id}}" data-id="{{$difficulty->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-4">
                    <i class="fa fa-arrows"></i>
                    <a class="text-large mb-1"
                       href="{{ route('admin.difficulties.edit', $difficulty) }}">{{ $difficulty->name }}</a>
                </div>
                <div class="col-4 col-sm-4 text-xlarge text-right">
                    {{ Site::format($difficulty->cost) }}
                </div>
                <div class="col-3 col-sm-4 text-xlarge text-right">
                    @can('delete', $difficulty)
                        <a class="btn btn-danger btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#difficulty-delete-form-{{$difficulty->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $difficulty->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal"
                        ><i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span></a>
                        <form id="difficulty-delete-form-{{$difficulty->id}}"
                              action="{{route('admin.difficulties.destroy', $difficulty)}}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>