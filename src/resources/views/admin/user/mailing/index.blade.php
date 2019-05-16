@extends('site::admin.mailing.create')

@section('mailing-breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
    </li>
@endsection

