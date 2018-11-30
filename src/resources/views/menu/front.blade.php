<div class="nav-container">
    <nav class="bg-light">
        <div class="nav-bar">
            <div class="module left">
                <a href="/">
                    <img class="logo logo-light" alt="Ferroli" src="{{asset('/images/logo_bianco.svg')}}">
                    <img class="logo logo-dark" alt="Ferroli" src="{{asset('/images/logo-dark.png')}}">
                </a>
            </div>
            <a class="module right mobile-menu d-inline-block d-lg-none navbar-toggle collapsed"
               href="#"
               data-toggle="collapse"
               data-target="#navbar"
               aria-expanded="false"
               aria-controls="navbar">
                <i class="fa fa-bars"></i>
            </a>
            <div class="module right d-inline-block mt-4 d-lg-none">
                @include('site::cart.nav')
            </div>
            <div class="module-group right d-none d-lg-block mt-2">
                @auth
                <div class="module left">
                    @admin()
                    <a class="btn btn-outline-ferroli" href="{{ route('admin') }}">@lang('site::messages.admin')</a>
                    @elseadmin()
                    <a class="btn btn-outline-ferroli" href="{{ route('home') }}">@lang('site::messages.home')</a>
                    @endadmin()
                </div>
                @endauth

                @guest
                <div class="module left">
                    <a class="btn btn-outline-ferroli" href="{{route('login')}}">Вход</a>
                    <a class="btn btn-outline-ferroli" href="{{route('register')}}">Регистрация</a>
                </div>
                @endguest
            </div>

            <div class="module-group right mauro d-none d-lg-block">
                <div class="module left">
                    <ul class="menu">

                        <li class="nav-item pb-2">
                            @include('site::cart.nav')
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services.index') }}">
                                <i class="fa fa-@lang('site::service.icon')"></i>
                                @lang('site::service.services')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dealers.index') }}">
                                <i class="fa fa-@lang('site::dealer.icon')"></i>
                                @lang('site::dealer.dealers')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('feedback') }}">
                                <i class="fa fa-@lang('site::feedback.icon')"></i>
                                @lang('site::messages.feedback')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div id="navbar" class="navbar-collapse collapse mobile-menu" aria-expanded="false">

            <ul class="nav navbar-nav">
                <li>
                    @auth
                    @admin()
                    <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
                    @elseadmin()
                    <a href="{{ route('home') }}">@lang('site::messages.home')</a>
                    @endadmin()
                    @endauth
                    @guest
                    <a href="{{route('login')}}">Вход</a>
                    <a href="{{route('register')}}">Регистрация</a>
                    @endguest
                </li>
                <li><a href="{{ route('products.index') }}" class="menuprinc">@lang('site::product.products')</a></li>
                <li><a href="{{ route('catalogs.index') }}" class="menuprinc">@lang('site::catalog.catalogs')</a></li>
                <li><a href="{{ route('datasheets.index') }}" class="menuprinc">@lang('site::datasheet.datasheets')</a>
                </li>
                <li><a href="{{ route('services.index') }}">@lang('site::service.services')</a></li>
                <li><a href="{{ route('dealers.index') }}">@lang('site::dealer.dealers')</a></li>
                <li><a href="{{ route('feedback') }}">@lang('site::messages.feedback')</a></li>
            </ul>
        </div>

    </nav>

</div>
<div class="d-none d-lg-block" style="clear:both;">
    <div style="position:absolute; width:100%; z-index:255;">

        <div class="container">
            <ul class="menu">
                <li class="neromenu has-dropdown @if(in_array(Request::route()->getName(), ['products.index', 'products.list', 'products.show'])) active @endif">
                    <a href="{{ route('products.index') }}" class="menuprinc">@lang('site::product.products')</a>
                </li>
                <li class="neromenu has-dropdown @if(in_array(Request::route()->getName(), ['catalogs.index', 'catalogs.show', 'catalogs.list', 'equipments.show']) ) active @endif">
                    <a href="{{ route('catalogs.index') }}" class="menuprinc">@lang('site::catalog.catalogs')</a>
                </li>
                <li class="neromenu has-dropdown @if(in_array(Request::route()->getName(), ['datasheets.index','datasheets.show'] )) active @endif">
                    <a href="{{ route('datasheets.index') }}" class="menuprinc">@lang('site::datasheet.datasheets')</a>
                </li>
            </ul>
        </div>
    </div>
</div>