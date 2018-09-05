@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => $product->name. ' '.__('site::scheme.schemes'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('products.show', $product), 'name' => $product->name],
            ['name' => __('site::scheme.schemes')],
        ]
    ])
@endsection

@section('content')
    <div class="container">
        @alert()@endalert
        @foreach($datasheets as $datasheet)
            <div class="row">
                <div class="col-md-2">
                    {{$datasheet->type->name}}
                </div>
                <div class="col-md-10">
                    <ul class="nav bg-light nav-pills nav-fill">
                        @foreach($datasheet->schemes as $scheme)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('products.scheme', [$product, $scheme])}}">{{$scheme->block->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection