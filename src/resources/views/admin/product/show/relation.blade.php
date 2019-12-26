<li class="list-group-item" id="product-relation-{{$relation->id}}">
    <div class="media align-items-center">
        <div class="media-body px-2">
            <div class="row">
                <div class="col-10">
                    <a href="{{route('admin.products.show', $relation)}}"
                       class="text-dark">{!! $relation->sku !!}</a>
                    <small class="text-muted d-block">{{$relation->name}}</small>
                </div>
                <div class="col-2">
                    <a class="pull-right btn btn-sm btn-light btn-row-delete"
                       data-form="#product-relation-delete-form-{{$relation->id}}"
                       data-btn-delete="@lang('site::messages.delete')"
                       data-btn-cancel="@lang('site::messages.cancel')"
                       data-label="@lang('site::messages.delete_confirm')"
                       data-message="@lang('site::messages.delete_sure') @lang('site::relation.relation') {{ $relation->name() }}?"
                       data-toggle="modal" data-target="#form-modal"
                       href="javascript:void(0);"
                       title="@lang('site::messages.delete')"><i class="fa fa-close"></i></a>
                    <form id="product-relation-delete-form-{{$relation->id}}"
                          action="{{route('admin.relations.destroy', [$product, $relation])}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</li>