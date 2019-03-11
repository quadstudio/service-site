@extends('layouts.app')

@section('title'){{$event->title}}@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => $event->title,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            
            ['name' => $event->title]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-8 news-content">
                

                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.region_id')</dt>
                    <dd class="col-sm-8">{{$event->region->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.city')</dt>
                    <dd class="col-sm-8">{{$event->city}}</dd>
                    @if($event->hasAddress())
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.address')</dt>
                        <dd class="col-sm-8">{{$event->address}}</dd>
                    @endif
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.date_from_to')</dt>
                    <dd class="col-sm-8">
                        @if($event->date_from == $event->date_to)
                            {{ $event->date_from() }}
                        @else
                            @lang('site::event.date_from') {{ $event->date_from() }}
                            @lang('site::event.date_to') {{ $event->date_to() }}
                        @endif
                    </dd>

                </dl>
				<p class="">{!! $event->annotation !!}</p><br>
                @if($event->hasDescription())
                    <p class="">{!! $event->description !!}</p>
                @endif
                @if($event->members->isNotEmpty())
                    <h3 class="mb-2">@lang('site::member.members')</h3>
                    @foreach($event->members as $member)
	                 @if($member->status_id==2)      @include('site::member.event.row') @endif
                    @endforeach
                @endif
                <div class="text-center my-4">
                    <a class="btn btn-ferroli" href="{{route('members.create', ['event_id' => $event->id])}}">
                        @lang('site::messages.leave') @lang('site::member.member')
                    </a>
                    <a class="btn btn-outline-ferroli ml-0 ml-sm-3 d-block d-sm-inline-block"
                       href="{!! $event->type->route !!}">@lang('site::event.help.other')</a>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-sm-0">
                <div class="card">
                    <img class="card-img-top" style="width: 100%;"
                         src="{{Storage::disk($event->image->storage)->url($event->image->path)}}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
