@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::catalog.catalogs'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::catalog.catalogs')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @foreach($catalogs as $catalog)
            <div class="col-lg-3 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <a href="{{route('catalogs.show', $catalog)}}"><img class="card-img-top" src="{{$catalog->image ? $catalog->image->src() : 'http://placehold.it/253x172'}}" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{route('catalogs.show', $catalog)}}">{{$catalog->name_plural}}</a>
                        </h4>
                        <p class="card-text">{{$catalog->description}}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
@endsection
