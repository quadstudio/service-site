@extends('layouts.app')
@section('header')

    <div class="container">
        <header>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item active"
                         style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>First Slide</h3>
                            <p>This is a description for the first slide.</p>
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Second Slide</h3>
                            <p>This is a description for the second slide.</p>
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class="carousel-item" style="background-image: url('http://placehold.it/1900x1080')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Third Slide</h3>
                            <p>This is a description for the third slide.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </header>
    </div>
@endsection
@section('content')
    <!-- Page Content -->
    <div class="container mt-5">

        <!-- Intro Content -->
        <div class="row">
            <div class="col-lg-6">
                <img class="img-fluid rounded mb-4" src="http://placehold.it/750x450" alt="">
            </div>
            <div class="col-lg-6">
                <h2>About Modern Business</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur
                    similique?
                    Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta
                    dolorem non blanditiis ex fugiat.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, magni, aperiam vitae illum
                    voluptatum
                    aut sequi impedit non velit ab ea pariatur sint quidem corporis eveniet. Odit, temporibus
                    reprehenderit
                    dolorum!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, consequuntur, modi mollitia corporis
                    ipsa
                    voluptate corrupti eum ratione ex ea praesentium quibusdam? Aut, in eum facere corrupti
                    necessitatibus
                    perspiciatis quis?</p>
            </div>
        </div>
        <!-- /.row -->

        <!-- Team Members -->
        <h2>Our Team</h2>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut
                            mollitia
                            eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut
                            mollitia
                            eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut
                            mollitia
                            eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Our Customers -->
        <h2>Our Customers</h2>
        <div class="row">
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection
