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
                <span class="sr-only">Назад</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Вперед</span>
            </a>
        </div>
    </header>
@endsection

@section('content')
    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h2 class="text-center">Новости</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <a href="" title="">
                        <img src="http://placehold.it/500x400" />
                    </a>
                    <a href="" title="">
                        <h3>Открылся новый сайт Ferroli</h3>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="" title="">
                        <img src="http://placehold.it/500x400" />
                    </a>
                    <a href="" title="">
                        <h3>Открылся новый сайт Ferroli</h3>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="" title="">
                        <img src="http://placehold.it/500x400" />
                    </a>
                    <a href="" title="">
                        <h3>Открылся новый сайт Ferroli</h3>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
