<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-3 col-xl-2">
                    <a href="{{ route('orders.show', $order) }}" class="text-large text-dark">{{$order->id}}</a>
                    <div class="p-1" style="font-weight:normal;color: {{ $order->status->color }}"><i
                                class="fa fa-{{ $order->status->icon }}"></i> {{ $order->status->name }}</div>
                </div>
                <div class="col-6 col-md-3 col-xl-2 text-right">
                    {{$order->created_at(true)}}
                </div>
                <div class="col-12 col-md-6 col-xl-8 text-right">
                    <div class="d-block">@lang('site::order.total'):</div>
                    <div class="text-large">{{ Site::format($order->total()) }}</div>
                    {{--<a href="{{route('admin.users.show', $repair->user)}}">{{ $repair->user->name }}</a>--}}
                    {{--<div class="text-muted">{{ $repair->user->address()->region->name }} / {{ $repair->user->address()->locality }}</div>--}}
                </div>
            </div>
        </div>
    </div>
</div>