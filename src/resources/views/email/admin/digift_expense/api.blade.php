@extends('layouts.email')

@section('title')
    @lang('site::digift_expense.email.api.title')
@endsection

@section('h1')
    @lang('site::digift_expense.email.api.h1')
@endsection

@section('body')
    <p>@lang('site::digift_expense.email.api.message'): <b>{{ $exception['message'] }}</b></p>
    <p>@lang('site::digift_expense.email.api.query_params'):</p>
    <ul>
        @foreach($request_data as $key => $value)
            <li>@lang('site::digift_expense.'.$key): {{$value}}</li>
        @endforeach
    </ul>
@endsection