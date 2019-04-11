<div class="card mb-2">
    <h6 class="card-header with-elements">
        <span class="card-header-title">@lang('site::mounting.mountings')</span>
    </h6>
    <div class="card-body">
        @foreach($act->contents as $repair)
            <div class="row border-bottom">
                <div class="col">
                    <a href="{{route('admin.repairs.show', $repair)}}">
                        № {{$repair->id}}
                    </a>
                </div>
                <div class="col">{{$repair->created_at->format('d.m.Y')}}</div>
                <div class="col">
                    <a href="{{route('admin.products.show', $repair->product)}}">{{$repair->product->name}}</a>
                </div>
                <div class="col">
                    {{Site::format($repair->total)}}
                </div>
            </div>
        @endforeach
    </div>
</div>