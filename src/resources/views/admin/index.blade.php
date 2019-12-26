@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.admin')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-sliders"></i> @lang('site::messages.admin')</h1>
        @alert()@endalert
        <div class="row mb-4">

            <div class="col-md-4">

                <!-- Tasks -->
                <div class="card mb-4">
                    <h6 class="card-header">@lang('site::messages.admin')</h6>
                    <div class="list-group">

                        <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.users.index') }}">
                            <i class="fa fa-@lang('site::user.icon')"></i> @lang('site::user.users')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.repairs.index') }}"><i
                                    class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')</a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.mountings.index') }}"><i
                                    class="fa fa-@lang('site::mounting.icon')"></i> @lang('site::mounting.mountings')
                        </a>
                        <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.acts.index') }}"><i
                                    class="fa fa-@lang('site::act.icon')"></i> @lang('site::act.acts')</a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.authorizations.index') }}"><i
                                    class="fa fa-@lang('site::authorization.icon')"></i> @lang('site::authorization.authorizations')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.mounters.index') }}"><i
                                    class="fa fa-@lang('site::mounter.icon')"></i> @lang('site::mounter.mounters')</a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.messages.index') }}"><i
                                    class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.orders.index') }}"><i
                                    class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders')</a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.contracts.index') }}">
                            <i class="fa fa-@lang('site::contract.icon')"></i> @lang('site::contract.contracts')
                        </a>

                        <hr/>

                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.catalogs.index') }}">
                            <i class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.equipments.index') }}">
                            <i class="fa fa-@lang('site::equipment.icon')"></i> @lang('site::equipment.equipments')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.products.index') }}">
                            <i class="fa fa-@lang('site::product.icon')"></i> @lang('site::product.cards')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.datasheets.index') }}">
                            <i class="fa fa-@lang('site::datasheet.icon')"></i> @lang('site::datasheet.datasheets')
                        </a>

                        <hr/>

                        <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-graduation-cap"></i> @lang('rbac::role.roles')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.permissions.index') }}">
                            <i class="fa fa-unlock-alt"></i> @lang('rbac::permission.permissions')
                        </a>

                        <hr/>

                        <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.announcements.index') }}">
                            <i class="fa fa-@lang('site::announcement.icon')"></i> @lang('site::announcement.announcements')
                        </a>
                        <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.events.index') }}">
                            <i class="fa fa-@lang('site::event.icon')"></i> @lang('site::event.events')
                        </a>
                        <a class="list-group-item list-group-item-action py-1"
                           href="{{ route('admin.members.index') }}">
                            <i class="fa fa-@lang('site::member.icon')"></i> @lang('site::member.members')
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Tasks -->
                <div class="card mb-4">
                    <h6 class="card-header">Справочники</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group">

				<a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.storehouses.index') }}">
                                    <i class="fa fa-@lang('site::storehouse.icon')"></i> @lang('site::storehouse.storehouses')
                                </a>
				<hr />
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.currencies.index') }}">
                                    <i class="fa fa-@lang('site::currency.icon')"></i> @lang('site::currency.currencies')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.currency_archives.index') }}">
                                    <i class="fa fa-@lang('site::archive.icon')"></i> @lang('site::archive.archives')
                                </a>

				<a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.organizations.index') }}">
                                    <i class="fa fa-@lang('site::organization.icon')"></i> @lang('site::organization.organizations')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.banks.index') }}">
                                    <i class="fa fa-@lang('site::bank.icon')"></i> @lang('site::bank.banks')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.contract-types.index') }}">
                                    <i class="fa fa-@lang('site::contract_type.icon')"></i> @lang('site::contract_type.contract_types')
                                </a>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.pages.index') }}">
                                    <i class="fa fa-@lang('site::page.icon')"></i> @lang('site::page.pages')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.routes.index') }}">
                                    <i class="fa fa-@lang('site::route.icon')"></i> @lang('site::route.routes')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.templates.index') }}">
                                    <i class="fa fa-@lang('site::template.icon')"></i> @lang('site::template.templates')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.event_types.index') }}">
                                    <i class="fa fa-@lang('site::event_type.icon')"></i> @lang('site::event_type.event_types')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.distances.index') }}">
                                    <i class="fa fa-@lang('site::distance.icon')"></i> @lang('site::distance.distances')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.difficulties.index') }}">
                                    <i class="fa fa-@lang('site::difficulty.icon')"></i> @lang('site::difficulty.difficulties')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.blocks.index') }}">
                                    <i class="fa fa-@lang('site::block.icon')"></i> @lang('site::block.blocks')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.schemes.index') }}">
                                    <i class="fa fa-@lang('site::scheme.icon')"></i> @lang('site::scheme.schemes')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.elements.index') }}">
                                    <i class="fa fa-@lang('site::element.icon')"></i> @lang('site::element.elements')
                                </a>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group">

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.engineers.index') }}">
                                    <i class="fa fa-@lang('site::engineer.icon')"></i> @lang('site::engineer.engineers')
                                </a>
                                <a class="list-group-item list-group-item-action py-1" href="{{ route('admin.trades.index') }}">
                                    <i class="fa fa-@lang('site::trade.icon')"></i> @lang('site::trade.trades')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.contragents.index') }}">
                                    <i class="fa fa-@lang('site::contragent.icon')"></i> @lang('site::contragent.contragents')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.addresses.index') }}">
                                    <i class="fa fa-@lang('site::address.icon')"></i> @lang('site::address.addresses')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.contacts.index') }}">
                                    <i class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.serials.index') }}">
                                    <i class="fa fa-@lang('site::serial.icon')"></i> @lang('site::serial.serials')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.mounting-bonuses.index') }}">
                                    <i class="fa fa-@lang('site::mounting_bonus.icon')"></i> @lang('site::mounting_bonus.mounting_bonuses')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.certificates.index') }}">
                                    <i class="fa fa-@lang('site::certificate.icon')"></i> @lang('site::certificate.certificates')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.price_types.index') }}">
                                    <i class="fa fa-@lang('site::price_type.icon')"></i> @lang('site::price_type.price_types')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.product_types.index') }}">
                                    <i class="fa fa-@lang('site::product_type.icon')"></i> @lang('site::product_type.product_types')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.file_groups.index') }}">
                                    <i class="fa fa-@lang('site::file_group.icon')"></i> @lang('site::file_group.file_groups')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.file_types.index') }}">
                                    <i class="fa fa-@lang('site::file_type.icon')"></i> @lang('site::file_type.file_types')
                                </a>

                                <hr/>

                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.authorization-roles.index') }}">
                                    <i class="fa fa-@lang('site::authorization_role.icon')"></i> @lang('site::authorization_role.authorization_roles')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.authorization-types.index') }}">
                                    <i class="fa fa-@lang('site::authorization_type.icon')"></i> @lang('site::authorization_type.authorization_types')
                                </a>
                                <a class="list-group-item list-group-item-action py-1"
                                   href="{{ route('admin.authorization-brands.index') }}">
                                    <i class="fa fa-@lang('site::authorization_brand.icon')"></i> @lang('site::authorization_brand.authorization_brands')
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
