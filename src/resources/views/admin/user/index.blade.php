@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::user.users')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::user.icon')"></i> @lang('site::user.users')
        </h1>

        @alert()@endalert

        <div class=" border p-3 mb-2">

            <a href="{{ route('admin.users.create') }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::user.create.dealer')</span>
            </a>
            <a href="{{ route('admin.mailings.create') }}"
               class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-ferroli">
                <i class="fa fa-@lang('site::mailing.icon')"></i>
                <span>@lang('site::messages.create') @lang('site::mailing.mailing')</span>
            </a>
            <button form="repository-form"
                    type="submit"
                    name="excel"
                    class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-upload"></i>
                <span>@lang('site::messages.upload') @lang('site::messages.to_excel')</span>
            </button>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        {{$users->render()}}
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $users])@endpagination

        <table class="table table-bordered bg-white table-sm table-hover">
            <tr>
                <th>Имя</th>
                <th>Основной регион</th>
                <th>Город</th>
                <th>ПЛЗ</th>
                <th>МНТЖ</th>
                <th>АСЦ</th>
                <th>ДЗЧ</th>
                <th>Дил</th>
                <th>Дистр</th>
                <th>ГенДист</th>
                <th>Eshop</th>
                <th>Вкл</th>
                <th>Email</th>
                <th>Отобр</th>
                <th>Дата рег.</th>
                <th>Вход</th>
                <th>Заказ</th>
            </tr>
            @foreach($users as $user)
                @include('site::admin.user.index.row')
            @endforeach
        </table>
            

        {{$users->render()}}
    </div>
@endsection
