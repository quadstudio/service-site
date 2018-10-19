<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/" style="position:relative;">
            <img alt="Logo" class="logo" src="{{asset('images/logo_bianco.svg')}}"
                 style="height:74px;position:absolute;top:-30px;left:-18px;">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
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
                    <a class="nav-link" href="{{ route('services.index') }}">@lang('site::service.services')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dealers.index') }}">@lang('site::dealer.dealers')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feedback') }}">@lang('site::messages.feedback')</a>
                </li>
                @auth
                @admin()
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="ml-1">Справочники <i class="mdi mdi-chevron-down"></i> </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <a class="dropdown-item" href="{{ route('admin.currencies.index') }}">
                            <i class="fa fa-@lang('site::currency.icon')"></i> @lang('site::currency.currencies')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.currency_archives.index') }}">
                            <i class="fa fa-@lang('site::archive.icon')"></i> @lang('site::archive.archives')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.warehouses.index') }}">
                            <i class="fa fa-@lang('site::warehouse.icon')"></i> @lang('site::warehouse.warehouses')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.organizations.index') }}">
                            <i class="fa fa-@lang('site::organization.icon')"></i> @lang('site::organization.organizations')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.banks.index') }}">
                            <i class="fa fa-@lang('site::bank.icon')"></i> @lang('site::bank.banks')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.catalogs.index') }}">
                            <i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.equipments.index') }}">
                            <i class="fa fa-@lang('site::equipment.icon')"></i> @lang('site::equipment.equipments')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.products.index') }}">
                            <i class="fa fa-@lang('site::product.icon')"></i> @lang('site::product.cards')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.serials.index') }}">
                            <i class="fa fa-@lang('site::serial.icon')"></i> @lang('site::serial.serials')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.distances.index') }}">
                            <i class="fa fa-@lang('site::distance.icon')"></i> @lang('site::distance.distances')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.difficulties.index') }}">
                            <i class="fa fa-@lang('site::difficulty.icon')"></i> @lang('site::difficulty.difficulties')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.datasheets.index') }}">
                            <i class="fa fa-@lang('site::datasheet.icon')"></i> @lang('site::datasheet.datasheets')
                        </a>

                        <a class="dropdown-item" href="{{ route('admin.blocks.index') }}">
                            <i class="fa fa-@lang('site::block.icon')"></i> @lang('site::block.blocks')
                        </a>

                        <a class="dropdown-item" href="{{ route('admin.schemes.index') }}">
                            <i class="fa fa-@lang('site::scheme.icon')"></i> @lang('site::scheme.schemes')
                        </a>

                        <a class="dropdown-item" href="{{ route('admin.elements.index') }}">
                            <i class="fa fa-@lang('site::element.icon')"></i> @lang('site::element.elements')
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.price_types.index') }}">
                            <i class="fa fa-@lang('site::price_type.icon')"></i> @lang('site::price_type.price_types')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.product_types.index') }}">
                            <i class="fa fa-@lang('site::product_type.icon')"></i> @lang('site::product_type.product_types')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.file_groups.index') }}">
                            <i class="fa fa-@lang('site::file_group.icon')"></i> @lang('site::file_group.file_groups')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.file_types.index') }}">
                            <i class="fa fa-@lang('site::file_type.icon')"></i> @lang('site::file_type.file_types')
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.pages.index') }}">
                            <i class="fa fa-@lang('site::page.icon')"></i> @lang('site::page.pages')
                        </a>
                    </div>
                </li>
                @endadmin()
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
                        <a class="dropdown-item" href="{{ route('admin.repairs.index') }}"><i
                                    class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')</a>
                        <a class="dropdown-item" href="{{ route('admin.acts.index') }}"><i
                                    class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')</a>
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
                        {{--<a class="dropdown-item" href="{{ route('admin.contacts.index') }}">--}}
                            {{--<i class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts')--}}
                        {{--</a>--}}
                        {{--<a class="dropdown-item" href="{{ route('admin.phones.index') }}">--}}
                            {{--<i class="fa fa-@lang('site::phone.icon')"></i> @lang('site::phone.phones')--}}
                        {{--</a>--}}

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-graduation-cap"></i> @lang('rbac::role.roles')
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.permissions.index') }}">
                            <i class="fa fa-unlock-alt"></i> @lang('rbac::permission.permissions')
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
                        @permission('messages')
                        <a class="dropdown-item" href="{{ route('messages.index') }}"><i
                                    class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
                        </a>
                        @endpermission
                        @permission('engineers')
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