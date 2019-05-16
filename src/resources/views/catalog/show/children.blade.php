@foreach($catalog->catalogs()->where('enabled', 1)->where(config('site.check_field'), 1)->orderBy(config('site.sort_order.catalog'))->get() as $children)
    @if($children->catalogs()->count() == 0 && $children->equipments()->where('enabled', 1)->where(config('site.check_field'), 1)->count() > 0)
        <hr />
        <h3>@if($children->h1) {!! $children->h1 !!} @else {{ $children->name_plural }} @endif</h3>
        <div class="row">
            @foreach($children->equipments()->where('enabled', 1)->where(config('site.check_field'), 1)->orderBy(config('site.sort_order.equipment'))->get() as $equipment)
                <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="{{route('equipments.show', $equipment)}}"><img class="card-img-top" src="{{$equipment->images->isNotEmpty() ? $equipment->images->first()->src() : 'http://placehold.it/250x150'}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{route('equipments.show', $equipment)}}">{{$equipment->name}}</a>
                            </h4>
                            <p class="card-text">{!! $equipment->annotation !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @include('site::catalog.show.children', ['catalog' => $children])
    @endif
@endforeach