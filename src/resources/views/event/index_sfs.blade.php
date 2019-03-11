@extends('layouts.app')

@section('title')@lang('site::event.events')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::event.sfs'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::event.events')]
        ]
    ])

	
@endsection
@section('content')
    <div class="container">
		@foreach($types as $type)
                <p class="card-text">{!! $type->annotation !!}</p>
        @endforeach
	<div class="text-center my-4"><p style="font-size:18px; font-style: bold; line-height: 25px;">
	Оставьте заявку на проведение мероприятия или обучения в Вашем регионе.</p>
                    <p><a href="{{route('members.create', ['type_id' => $type->id])}}" class="btn btn-ferroli">@lang('site::messages.leave') @lang('site::member.member')</a></p>
	<p style="font-size:18px; font-style: bold; line-height: 25px;"> Либо зарегистрируйтесь на запланированное мероприятие в Вашем городе: </p>
@filter(['repository' => $repository])@endfilter                    
                </div>       
        
        <div class="row news-list">
            @each('site::event.index.row', $events, 'event')
        </div>
        </div>
@endsection