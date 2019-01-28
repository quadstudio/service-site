@extends('layouts.app')

@section('header')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('images/banner/ferroli_home.jpg')}}" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('images/banner/ferroli_home_1.jpg')}}" alt="">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.prev')</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.next')</span>
            </a>
        </div>
    </header>
@endsection

@section('content')
    <div class="container">
        @include('site::news.carousel')
        @include('site::event_type.main')
        @include('site::event.main')
        @include('site::member.main')
    </div>

@endsection
