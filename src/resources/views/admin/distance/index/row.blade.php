<div class="items-col col-12 sort-item" id="distance-{{$distance->id}}" data-id="{{$distance->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-4">
                    <i class="fa fa-arrows"></i>
                    <a class="text-large mb-1"
                       href="{{ route('admin.distances.edit', $distance) }}">{{ $distance->name }}</a>
                </div>
                <div class="col-4 col-sm-4 text-xlarge text-right">
                    {{ Site::format($distance->cost) }}
                </div>
                <div class="col-3 col-sm-4 text-xlarge text-right">
                    @can('delete', $distance)
                        <a class="btn btn-danger btn-row-delete"
                           title="@lang('site::messages.delete')"
                           href="javascript:void(0);"
                           data-form="#distance-delete-form-{{$distance->id}}"
                           data-btn-delete="@lang('site::messages.delete')"
                           data-btn-cancel="@lang('site::messages.cancel')"
                           data-label="@lang('site::messages.delete_confirm')"
                           data-message="@lang('site::messages.delete_sure') {{ $distance->name }}?"
                           data-toggle="modal"
                           data-target="#form-modal"
                        ><i class="fa fa-close"></i> <span class="d-none d-sm-inline-block">@lang('site::messages.delete')</span></a>
                        <form id="distance-delete-form-{{$distance->id}}"
                              action="{{route('admin.distances.destroy', $distance)}}"
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