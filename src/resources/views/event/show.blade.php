@extends('layouts.app')

@section('title'){{$event->title}}@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => $event->title,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['url' => route('event_types.show', $event->type), 'name' =>$event->type->name],
            ['name' => $event->title]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        @alert()@endalert()
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
                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.date')</dt>
                    <dd class="col-sm-8">
                        @if($event->date_from == $event->date_to)
                            {{ $event->date_from->format('d.m.Y') }}
                        @else
                            @lang('site::event.date_from') {{ $event->date_from->format('d.m.Y') }}
                            @lang('site::event.date_to') {{ $event->date_to->format('d.m.Y') }}
                        @endif
                    </dd>
                    <dt class="col-sm-4 text-left text-sm-right"></dt>
                    <dd class="col-sm-8">
                        <div class="bg-lightest font-italic p-4 text-big">{{$event->annotation }}</div>
                    </dd>

                </dl>
                @if($event->hasDescription())
                    <p class="">{!! $event->description !!}</p>
                @endif
                @if($event->members()->where('status_id', 2)->exists())
                    <h3 class="mb-2">@lang('site::member.members')</h3>
                    @foreach($event->members()->where('status_id', 2)->get() as $member)
                        @include('site::member.event.row')
                    @endforeach
                @endif
                <div class="text-center my-4">
                    <a class="btn btn-ferroli" href="{{route('members.register', $event)}}">
                        @lang('site::event.register')
                    </a>
                    <a class="btn btn-outline-ferroli ml-0 ml-sm-3 d-block d-sm-inline-block"
                       href="{{route('event_types.show', $event->type)}}">@lang('site::event.help.other')</a>
                    @admin()
                    <a class="btn btn-warning ml-0 ml-sm-3 d-block d-sm-inline-block"
                       href="{{route('admin.events.show', $event)}}">
                        <i class="fa fa-folder-open"></i>
                        @lang('site::messages.open_admin')
                    </a>
                    @endadmin()
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-sm-0">
                @if($event->image->fileExists)
                    <div class="card">
                        <img class="card-img-top" style="width: 100%;"
                             src="{{Storage::disk($event->image->storage)->url($event->image->path)}}" alt="">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
