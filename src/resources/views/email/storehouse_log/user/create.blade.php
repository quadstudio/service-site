@extends('layouts.email')

@section('title')
    @lang('site::storehouse_log.email.create.title')
@endsection

@section('h1')
    @lang('site::storehouse_log.email.create.h1')
@endsection

@section('body')
    <p>@lang('site::storehouse.error.upload.message', [
        'date' => $storehouseLog->created_at->format('d.m.Y H:i'),
        'link' => '<a target="_blank" href="'. route('storehouses.show', $storehouseLog->storehouse) .'">'. $storehouseLog->storehouse->name .'</a>'
    ])</p>
    <ul>
        @foreach($storehouseLog->message as $message)
            <li>&nbsp;{{$message}}</li>
        @endforeach
    </ul>
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('storehouses.show', $storehouseLog->storehouse) }}">
            &#128194; @lang('site::messages.open') {{$storehouseLog->storehouse->name}}</a>
    </p>
@endsection