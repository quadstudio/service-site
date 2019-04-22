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
            <div class="module-group right d-none d-lg-block mt-2 pr-2">
                @auth
                <div class="dropdown">
                    <button class="btn btn-outline-ferroli dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="user-logo" src="{{$current_user->logo}}" style="width:25px!important;height: 25px"
                             class="rounded-circle mr-2">
                        {{ str_limit(auth()->user()->name, 25) }}

                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        @admin()
                        <a class="dropdown-item" href="{{ route('admin') }}">
                            <i class="fa fa-sliders"></i> @lang('site::messages.admin')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                            <i class="fa fa-@lang('site::user.icon')"></i> @lang('site::user.users')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.repairs.index') }}"><i
                                    class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')</a>
                        <a class="dropdown-item" href="{{ route('admin.acts.index') }}"><i
                                    class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')</a>
                        <a class="dropdown-item" href="{{ route('admin.authorizations.index') }}"><i
                                    class="fa fa-@lang('site::authorization.icon')"></i> @lang('site::authorization.authorizations')</a>
                        <a class="dropdown-item" href="{{ route('admin.mounters.index') }}"><i
                                    class="fa fa-@lang('site::mounter.icon')"></i> @lang('site::mounter.mounters')</a>
                        <a class="dropdown-item" href="{{ route('admin.messages.index') }}"><i
                                    class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')</a>
                        <a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i
                                    class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.engineers.index') }}">
                            <i class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.launches.index') }}">
                            <i class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.trades.index') }}">
                            <i class="fa fa-@lang('site::trade.icon')"></i> @lang('site::trade.trades')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.contragents.index') }}">
                            <i class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.addresses.index') }}">
                            <i class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses')
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-graduation-cap"></i> @lang('rbac::role.roles')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permissions.index') }}">
                            <i class="fa fa-unlock-alt"></i> @lang('rbac::permission.permissions')
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.news.index') }}">
                            <i class="fa fa-@lang('site::news.icon')"></i> @lang('site::news.news')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.events.index') }}">
                            <i class="fa fa-@lang('site::event.icon')"></i> @lang('site::event.events')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.members.index') }}">
                            <i class="fa fa-@lang('site::member.icon')"></i> @lang('site::member.members')
                        </a>
                        @elseadmin()

                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="fa fa-desktop"></i> @lang('site::messages.home')
                        </a>
                        @permission('orders')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('orders.index') }}"><i
                                    class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')
                        </a>
                        @endpermission
                        @permission('repairs')
                        <a class="dropdown-item" href="{{ route('repairs.index') }}"><i
                                    class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
                        </a>
                        @endpermission
                        @permission('acts')
                        <a class="dropdown-item" href="{{ route('acts.index') }}"><i
                                    class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')
                        </a>
                        @endpermission
                        @permission('authorizations')
                        <a class="dropdown-item" href="{{ route('authorizations.index') }}"><i
                                    class="fa fa-@lang('site::authorization.icon')"></i> @lang('site::authorization.authorizations')
                        </a>
                        @endpermission
                        @permission('messages')
                        <a class="dropdown-item" href="{{ route('messages.index') }}"><i
                                    class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
                        </a>
                        @endpermission
                        @permission('engineers')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('engineers.index') }}">
                            <i class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')
                        </a>
                        @endpermission
                        @permission('launches')
                        <a class="dropdown-item" href="{{ route('launches.index') }}">
                            <i class="fa fa-@lang('site::launch.icon')"></i> @lang('site::launch.launches')
                        </a>
                        @endpermission
                        @permission('trades')
                        <a class="dropdown-item" href="{{ route('trades.index') }}">
                            <i class="fa fa-@lang('site::trade.icon')"></i> @lang('site::trade.trades')
                        </a>
                        @endpermission
                        @permission('contragents')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('contragents.index') }}">
                            <i class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents_user')
                        </a>
                        @endpermission
                        @permission('contacts')
                        <a class="dropdown-item" href="{{ route('contacts.index') }}">
                            <i class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts')
                        </a>
                        @endpermission
                        @permission('addresses')
                        <a class="dropdown-item" href="{{ route('addresses.index') }}">
                            <i class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses')
                        </a>
                        @endpermission

                        @endadmin()
                        <div class="dropdown-divider"></div>
                        @if(isset($current_admin) && is_object($current_admin))
                            <a href="{{ route('users.admin',$current_admin) }}"
                               class="dropdown-item">
                                <i class="fa fa-sign-in"></i>
                                @lang('site::user.force_admin')
                            </a>
                        @endif
                        <a href="javascript:void(0);" class="dropdown-item notify-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> {{ __('site::user.sign_out') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
                {{--<div class="module left">--}}
                    {{----}}
                    {{--@admin()--}}
                    {{--<a class="btn btn-outline-ferroli" href="{{ route('admin') }}">@lang('site::messages.admin')</a>--}}
                    {{--@elseadmin()--}}
                    {{--<a class="btn btn-outline-ferroli" href="{{ route('home') }}">@lang('site::messages.home')</a>--}}
                    {{--@endadmin()--}}
                {{--</div>--}}
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
                            <a class="nav-link" href="https://yadi.sk/d/7CXTYatd-Xp4bw">
                                Каталог и прайс (PDF)
                            </a>
                        </li>
			            <li class="nav-item">
                            <a class="nav-link" href="{{ route('service-centers') }}">
                                <i class="fa fa-@lang('site::map.service_center.icon')"></i>
                                @lang('site::map.service_center.menu')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('where-to-buy') }}">
                                <i class="fa fa-@lang('site::map.where_to_buy.icon')"></i>
                                @lang('site::map.where_to_buy.menu')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('online-stores') }}">
                                <i class="fa fa-@lang('site::map.online_store.icon')"></i>
                                @lang('site::map.online_store.menu')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mounter-requests') }}">
                                <i class="fa fa-@lang('site::map.mounter_request.icon')"></i>
                                @lang('site::map.mounter_request.menu')
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
                <li><a href="{{ route('products.index') }}">@lang('site::product.products')</a></li>
                <li><a href="{{ route('catalogs.index') }}">@lang('site::catalog.catalogs')</a></li>
                <li><a href="{{config('catalog_price_pdf')}}">Каталог и прайс (PDF)</a></li>
                <li><a href="{{ route('datasheets.index') }}">@lang('site::datasheet.datasheets')</a></li>
                <li><a href="{{ route('service-centers') }}">@lang('site::map.service_center.menu')#</a></li>
                <li><a href="{{ route('where-to-buy') }}">@lang('site::map.where_to_buy.menu')#</a></li>
                <li><a href="{{ route('online-stores') }}">@lang('site::map.online_store.menu')#</a></li>
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
