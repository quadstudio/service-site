@extends('layouts.email')

@section('title')
    @lang('site::feedback.mail.title')
@endsection

@section('h1')
    @lang('site::feedback.mail.h1')
@endsection

@section('body')
    <p>@lang('site::feedback.mail.content', ['name' => $data['name'], 'email' => $data['email']])
        <a target="_blank" href="{{route('index')}}">{{env('APP_URL')}}</a>
    </p>
    <p style="padding: 20px;background-color: #fafafa;border:1px solid #eaeaea;">{!! $data['message'] !!}</p>
@endsection