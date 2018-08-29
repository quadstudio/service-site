<div class="items-col col-12" data-id="{{$scheme->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-1 col-sm-2">
                    <img class="img-thumbnail width-70" src="{{$scheme->image->src()}}">
                </div>
                <div class="col-8 col-sm-6">
                    <a class="text-large mb-1"
                       href="{{ route('admin.schemes.show', $scheme) }}">{{ $scheme->block->name }}</a>
                </div>
                <div class="col-3 col-sm-4 text-right">
                    @lang('site::element.elements'): {{ $scheme->elements()->count() }}
                </div>
            </div>
        </div>
    </div>
</div>