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
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::user.icon')"></i> @lang('site::reports.asc.h1')
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
                <th>Регион/город юр</th>
                <th>Город склад</th>
                <th>Роли</th>
                <th>Авторизации</th>
                <!-- Сумма заказов за период выбранный в фильтре. -->
				<th>&sum; заказов &#916;</th>
				
				<!-- Кол-во заказов за период. -->
				<th>Заказы &#916;</th>
				
				<!-- Кол-во заказов всего. -->
				<th>Заказов всего</th>
				<!-- Даты и суммы 3-х последних заказов. -->
				<th>Заказы последние</th>
				
				<!-- Сумма входящих заказов за период. -->
				<th>&sum; вход. заказов &#916;</th>
				
				<!-- Кол-во входящих заказов за период. -->
				<th>Вход. заказы &#916;</th>
				
				<!-- Кол-во входящих заказов всего. -->
				<th>Вход. заказы</th>
				
				<!-- Кол-во АГР за период. -->
				<th>АГР &#916;</th>
				<!-- Кол-во актов за календарный текущий квартал. -->
				<th>АГР квартал</th>
				
				<!-- Даты 3-х последних АГР. -->
				<th>Посл. АГР</th>
				
				<!-- Даты последнего обновления складов пользователя. -->
				<th>Дата обновл. складов</th>
				
				<!-- Количество запчастей на складах. -->
				<th>ЗИП на складах</th>
				<!-- Стоимость всех запчастей на складах. -->
				<th>Зип на складах &sum;</th>
                
            </tr>
            @foreach($users as $user)
                @include('site::admin.reports.asc.index.row')
            @endforeach
        </table>
            

        {{$users->render()}}
    </div>
@endsection
