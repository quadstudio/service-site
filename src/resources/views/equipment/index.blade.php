@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::equipment.equipments'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::equipment.equipments')]
        ]
    ])
@endsection
@section('content')
    <div class="container">

    </div>
@endsection
