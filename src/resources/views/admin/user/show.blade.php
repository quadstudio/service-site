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
        <h1 class="header-title m-t-0 m-b-20"><i class="fa fa-@lang('site::user.icon')"></i> {{ $user->name }}</h1>
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
                <a class="nav-link" data-toggle="tab" href="#contragents-tab">@lang('site::contragent.contragents') <span class="badge badge-primary">{{$user->contragents()->count()}}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contacts-tab">@lang('site::contact.contacts') <span class="badge badge-primary">{{$user->contacts()->count()}}</span></a>
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
                                <td>@lang('site::user.sc')</td>
                                <td>{{ $user->sc }}</td>
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
            <div class="tab-pane container fade p-0" id="contragents-tab">
                <div class="card border-top-0">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="tab-pane container fade p-0" id="contacts-tab">
                <div class="card border-top-0">
                    <div class="card-body"></div>
                </div>
            </div>
        </div>

    </div>
@endsection
