@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::product_type.index')</li>
        </ol>
        <h1 class="header-titlemb-4">@lang('site::product_type.index')</h1>
        <hr/>


    </div>
@endsection
