@extends('layouts.email')

@section('title')
    Смена статуса отчета по ремонту
@endsection

@section('h1')
    Смена статуса отчета по ремонту
@endsection

@section('body')

    <p>Статус отчета по ремонту № {{$repair->id}} сменен на <span style="padding:2px 4px;color:#fff;background-color:{{$repair->status->color}}">{{$repair->status->name}}</span></p>
    @if($adminMessage)
        <p>Сообщение от администратора: {!! nl2br($adminMessage) !!}</p>
    @endif
    <p>
        <a class="btn btn-ferroli btn-lg" href="{{ route('repairs.show', $repair) }}">
            &#128194; Открыть @lang('site::repair.repair')</a>
    </p>
@endsection