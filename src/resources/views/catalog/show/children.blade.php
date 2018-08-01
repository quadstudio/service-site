@foreach($catalog->catalogs()->where('enabled', 1)->get() as $children)
    @php @endphp
    @if($children->catalogs()->count() == 0 && $children->equipments()->where('enabled', 1)->count() > 0)
        <hr />
        <h3>{{ $children->parentTreeName() }}</h3>
        <div class="row">
            @foreach($children->equipments()->where('enabled', 1)->get() as $equipment)
                <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="{{route('equipments.show', $equipment)}}"><img class="card-img-top" src="http://placehold.it/250x150" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{route('equipments.show', $equipment)}}">{{$equipment->name}}</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam
                                aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque
                                deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        @include('site::catalog.show.children', ['catalog' => $children])
    @endif
@endforeach