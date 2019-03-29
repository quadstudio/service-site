<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <a class="text-big" href="{{ route('admin.serials.show', $serial) }}">{{ $serial->id }}</a>

                </div>
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="mb-2 mb-md-0 text-muted">
                        <span class="d-block"><a
                                    href="{{route('admin.products.show', $serial->product)}}">{{ $serial->product->name }}</a></span>
                        {{--<span class="d-block">@lang('site::contragent.ogrn'):--}}
                        {{--{{ $contragent->ogrn }}</span>--}}
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="mb-2 mb-md-0 text-secondary text-left text-md-right">
                        @if($serial->product->equipment()->exists())
                            <span class="d-block"><a href="{{route('admin.equipments.show', $serial->product->equipment)}}">{{optional($serial->product->equipment)->name }}</a></span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
