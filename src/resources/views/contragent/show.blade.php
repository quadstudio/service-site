@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contragents.index') }}">@lang('site::contragent.contragents')</a>
            </li>
            <li class="breadcrumb-item active">{{ $contragent->name }}</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contragent.icon')"></i> {{ $contragent->name }}</h1>
        <div class="row">
            <div class="col mt-2">
                <a href="{{ route('contragents.edit', $contragent) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    <span>@lang('site::messages.edit')</span>
                </a>
                <a href="{{ route('contragents.index') }}" class="btn btn-secondary">
                    <i class="fa fa-reply"></i>
                    <span>@lang('site::messages.back')</span>
                </a>
            </div>
        </div>
        <div class="card my-4">
            <div class="card-body">
                <table class="table user-view-table m-0">
                    <tbody>
                    <tr>
                        <td>@lang('site::contragent.name')</td>
                        <td>{{ $contragent->name }}</td>
                    </tr>
                    <tr>
                        <td>@lang('site::contragent.type_id')</td>
                        <td>{{ $contragent->type->name }}</td>
                    </tr>
                    <tr>
                        <td>@lang('site::contragent.nds')</td>
                        <td>
                            @bool(['bool' => $contragent->nds == 1])@endbool
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('site::contragent.created_at')</td>
                        <td>{{ $contragent->created_at() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-group mb-4">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">@lang('site::contragent.header.legal')</h5>
                    <table class="table user-view-table m-0">
                        <tbody>
                        <tr>
                            <td>@lang('site::contragent.inn')</td>
                            <td>{{ $contragent->inn }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.ogrn')</td>
                            <td>{{ $contragent->ogrn }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.okpo')</td>
                            <td>{{ $contragent->okpo }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.kpp')</td>
                            <td>{{ $contragent->kpp }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">@lang('site::contragent.header.payment')</h5>
                    <table class="table user-view-table m-0">
                        <tbody>
                        <tr>
                            <td>@lang('site::contragent.rs')</td>
                            <td>{{ $contragent->rs }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.bik')</td>
                            <td>{{ $contragent->bik }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.bank')</td>
                            <td>{{ $contragent->bank }}</td>
                        </tr>
                        <tr>
                            <td>@lang('site::contragent.ks')</td>
                            <td>{{ $contragent->ks }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection
