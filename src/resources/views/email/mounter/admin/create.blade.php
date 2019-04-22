@extends('layouts.email')

@section('title')
    @lang('site::mounter.email.create.title')
@endsection

@section('h1')
    @lang('site::mounter.email.create.h1')
@endsection

@section('body')
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('admin.mounters.show', $mounter) }}">
            &#128194; @lang('site::messages.open') @lang('site::mounter.mounter') № {{$mounter->id }}</a>
    </p>
@endsection