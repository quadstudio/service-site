<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/" style="position:relative;">
            <img alt="Logo" class="logo" src="{{asset('images/logo_bianco.svg')}}"
                 style="height:74px;position:absolute;top:-30px;left:-18px;">
        </a>
        <a href="#" class="navbar-toggler navbar-toggler-right bg-dark"
           data-toggle="collapse"
           data-target="#navbarResponsive"
           aria-controls="navbarResponsive"
           aria-expanded="false"
           aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </a>
        <div class="collapse navbar-collapse" style="z-index: 25000 !important;" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">@lang('site::product.products')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalogs.index') }}">@lang('site::catalog.catalogs')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('datasheets.index') }}">@lang('site::datasheet.datasheets')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('service-centers') }}">@lang('site::service.services')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('where-to-buy') }}">@lang('site::dealer.dealers')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feedback') }}">@lang('site::messages.feedback')</a>
                </li>
                @auth

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        {{ str_limit(Auth::user()->name, 25) }} <i class="mdi mdi-chevron-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        @admin()
                        <a class="dropdown-item" href="{{ route('admin') }}">
                            <i class="fa fa-sliders"></i> @lang('site::messages.admin')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                            <i class="fa fa-@lang('site::user.icon')"></i> @lang('site::user.users')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.repairs.index') }}">
                            <i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.mountings.index') }}">
                            <i class="fa fa-@lang('site::mounting.icon')"></i> @lang('site::mounting.mountings')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.acts.index') }}">
                            <i class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.authorizations.index') }}">
                            <i class="fa fa-@lang('site::authorization.icon')"></i> @lang('site::authorization.authorizations')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.messages.index') }}">
                            <i class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                            <i class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')
                        </a>

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

                        @permission('repairs')
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('repairs.index') }}"><i
                                    class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
                        </a>
                        @endpermission
                        @permission('mountings')
                        <a class="dropdown-item" href="{{ route('mountings.index') }}"><i
                                    class="fa fa-@lang('site::mounting.icon')"></i> @lang('site::mounting.mountings')
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
                        @permission('orders')

                        <a class="dropdown-item" href="{{ route('orders.index') }}"><i
                                    class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')
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
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>