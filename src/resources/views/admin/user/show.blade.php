@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
        <h1 class="header-titlemb-4"><i class="fa fa-@lang('site::user.icon')"></i> {{ $user->name }}</h1>
        @alert()@endalert()
        <div class="row">
            <div class="col mt-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
                <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-secondary">
                    <i class="fa fa-@lang('site::order.icon')"></i>
                    <span>@lang('site::order.orders')</span>
                </a>
                @if($user->can_export())
                    <a href="{{ route('admin.users.export', $user) }}" class="btn btn-success">
                        <i class="fa fa-send"></i>
                        <span>@lang('site::user.export')</span>
                    </a>
                @endif
            </div>
        </div>
        <ul class="nav nav-tabs mt-4">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home"><i class="fa fa-home"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#orders-tab">@lang('site::order.orders') <span
                            class="badge badge-primary">{{$user->orders()->count()}}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contragents-tab">@lang('site::contragent.contragents')
                    <span class="badge badge-primary">{{$user->contragents()->count()}}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contacts-tab">@lang('site::contact.contacts') <span
                            class="badge badge-primary">{{$user->contacts()->count()}}</span></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane container active p-0" id="home">
                <div class="card border-top-0">
                    <div class="card-body">
                        <table class="table m-0">
                            <tbody>
                            <tr>
                                <td>@lang('site::user.name')</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.type_id')</td>
                                <td>{{ $user->type->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.email')</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.guid')</td>
                                <td>{{ $user->guid }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.price_type_id')</td>
                                <td>{{ $user->price_type->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.warehouse_id')</td>
                                <td>{{ $user->warehouse->name }}</td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.active')</td>
                                <td>
                                    @bool(['bool' => $user->active == 1])@endbool
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.verified')</td>
                                <td>
                                    @bool(['bool' => $user->verified == 1])@endbool
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.is_asc')</td>
                                <td>
                                    @bool(['bool' => $user->hasRole('asc')])@endbool
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.display')</td>
                                <td>
                                    @bool(['bool' => $user->display == 1])@endbool
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('site::user.created_at')</td>
                                <td>{{ $user->created_at() }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane container fade p-0" id="orders-tab">
                <div class="card border-top-0">
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="tab-pane container fade p-0" id="contragents-tab">
                <div class="card border-top-0">
                    <div class="card-body">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th scope="col">@lang('site::contragent.name')</th>
                                <th scope="col">@lang('site::contragent.type_id')</th>
                                <th scope="col">@lang('site::contragent.inn')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->contragents as $contragent)
                                <tr>
                                    <td>
                                        <a href="{{route('admin.contragents.show', $contragent)}}">{{ $contragent->name }}</a>
                                    </td>
                                    <td>{{ $contragent->type->name }}</td>
                                    <td>{{ $contragent->inn }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="tab-pane container fade p-0" id="contacts-tab">
                <div class="card border-top-0">
                    <div class="card-body">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th scope="col">@lang('site::contact.name')</th>
                                <th scope="col">@lang('site::contact.type_id')</th>
                                <th scope="col">@lang('site::phone.phones')</th>
                                <th scope="col">@lang('site::contact.position')</th>
                                <th scope="col">@lang('site::contact.web')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>{{--<a href="{{route('admin.contacts.show', $contact)}}">--}}
                                    <td>{{ $contact->type->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach($contact->phones as $phone)
                                                <li>{{$phone->country->phone}}{{$phone->number}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $contact->position }}</td>
                                    <td>{{ $contact->web }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
