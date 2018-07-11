@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.equipment')</li>
        </ol>
        <div class="row">
            <div class="col-sm-12">
                

            </div>
        </div>
    </div>
@endsection
