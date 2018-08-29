<div class="items-col col-12" data-id="{{$element->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-8 col-sm-6">
                    <a class="text-large mb-1"
                       {{--{{ route('admin.elements.edit', $element) }}--}}
                       href="#">{{ $element->product->sku }}</a>
                </div>
                <div class="col-4 col-sm-6 text-right">
                    {{--@lang('site::scheme.schemes'): {{ $element->schemes()->count() }}--}}
                </div>
            </div>
        </div>
    </div>
</div>