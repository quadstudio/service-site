<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <title>@lang('site::messages.title')</title>

    <meta name="description" content="@lang('site::messages.description')">
    <meta name="keyword" content="@lang('site::messages.keyword')">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="QuadStudio"/>
    <meta name="viewport"
          content="width=device-width, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<link rel="shortcut icon" href="{{asset('favicon.ico')}}">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:300,400&amp;subset=cyrillic"--}}
          {{--rel="stylesheet">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/favicon/apple-icon-72x72')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body id="page-top" class="{{ $current_body_class }}">
@section('navbar') @include('site::menu.'.$current_menu) @show
<div class="main-container">
    @yield('header')
    @yield('content')
</div>
@section('footer')
    <footer class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <img alt="Logo" class="logo" src="{{asset('images/logo_bianco.svg')}}"
                         style="max-width:70%; margin-left:-30px; margin-top:-20px;">
                    <div>
                        Ферроли ООО<br>
                        РБ, г.Минск<br>
                        ул. Ленина, д.5<br>
                        Тел: +375-000-000-0000<br>
                        Факс: +375-000-000-0000<br>
                        Email: info@ferroli.ru<br>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <p class="title">Услуги для вас</p>
                        <hr>
                        <ul class="recent-post">
                            <li><b class="title">Консультации продажи</b></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <p class="title">&nbsp;</p>
                        <hr>
                        <ul class="recent-post">
                            <li><b class="title">Консультации сервис</b></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <p class="title">Сертификаты</p>
                        <hr>
                        <div>
                            <img src="{{asset('images/certificazioni.png')}}" style="margin-right:22px;"/>
                            <img src="{{asset('images/tuv.png')}}" style="margin-right:22px;"/>
                            <img src="{{asset('images/eac.png')}}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="sub">© Copyright {{ env('APP_NAME') }} {{ date('Y') }}</span>
                </div>
            </div>
        </div>
        <a class="btn btn-sm fade-half back-to-top inner-link" href="#page-top">Вверх</a>
    </footer>
@show

@stack('scripts')

@include('site::modal.form')
</body>
</html>