@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('equipment::messages.index')</a>
            </li>

        </ol>

    </div>
@endsection
