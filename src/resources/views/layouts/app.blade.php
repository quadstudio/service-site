<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <title>@if($page_title) {{$page_title}} - @else @yield('title') @endif @lang('site::messages.title')</title>

    <meta name="description" content="@if($page_description) {{$page_description}} @else @yield('description') @endif">
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
    @stack('styles')
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
                        ООО «ФерролиРус» <br>
                        127238, Москва, Дмитровское ш 71 Б<br>
                        Тел. (495) 646 06 23<br>
                        Email: info@ferroli.ru<br>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <hr>
                        <ul class="recent-post">
                            <li><a class="title" href="/services">Сервисные центры</a></li>
                            <li><a class="title" href="/dealers">Где купить?</a></li>
                            <li><a class="title" href="/products" class="title">Запчасти</a></li>
                            <li><a class="title" href="/catalogs" class="title">Оборудование</a></li>
                            <li><a class="title" href="/datasheets" class="title">Документация</a></li>
                            <li><a class="title" href="https://yadi.sk/d/7CXTYatd-Xp4bw" class="title">Каталог и прайс (PDF)</a></li>
                            <li><a class="title" href="/feedback">Контакты</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <hr>
                        <ul class="recent-post">
                            <li><a class="title" href="/login">Вход</a></li>
                            <li><a class="title" href="/register">Регистрация</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="widget">
                        <p class="title"></p>
                        <hr>
                        <div>
                            <img src="{{asset('images/certificazioni.png')}}" style="margin-right:22px;"/>
                            <img src="{{asset('images/tuv.png')}}" style="margin-right:22px;"/>
                            <img src="{{asset('images/eac.png')}}"/>
                        </div>
                        <div>
                            <br/><br/>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <span class="sub">© Copyright {{ env('APP_NAME') }} {{ date('Y') }}</span>
                </div>
                <div class="col-lg-3"> &nbsp;</div>
                <div class="col-lg-3"> &nbsp;</div>
                <div class="col-lg-3">
                    <a target="_blank" href="https://www.instagram.com/ferroli_rus_bel/"><img
                                style="width: 30px; height: 30px; margin-left:45px; margin-right:22px;"
                                onmouseover="this.src='/images/inst-footer-hover.png';"
                                onmouseout="this.src='images/inst-footer.png';" src="/images/inst-footer.png"></$
                    <a href="#"><img style="width: 30px; height: 30px; margin-right:22px;"
                                     onmouseover="this.src='/images/fb-footer-hover.png';"
                                     onmouseout="this.src='images/fb-footer.png';" src="/images/fb-footer.png"></a>
                    <a href="#"><img style="width: 30px; height: 30px; margin-right:22px;"
                                     onmouseover="this.src='/images/youtube-footer-hover.png';"
                                     onmouseout="this.src='images/youtube-footer.png';"
                                     src="/images/youtube-footer.png"></a>


                </div>
            </div>
        </div>
        <a class="btn btn-sm fade-half back-to-top inner-link" href="#page-top">Вверх</a>
    </footer>
@show

@stack('scripts')

@include('site::modal.form')

@if($current_route == 'index' OR substr($current_route,0,7) == 'product' OR substr($current_route,0,8) == 'catalogs' OR substr($current_route,0,10) == 'datasheets')
    {{$current_route}}
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter51104846 = new Ya.Metrika2({
                        id: 51104846,
                        clickmap: true,
                        trackLinks: true,
                        accurateTrackBounce: true,
                        webvisor: true
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/tag.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks2");
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/51104846" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->


@endif

</body>
</html>
