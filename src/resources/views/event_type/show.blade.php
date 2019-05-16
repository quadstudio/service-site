@extends('layouts.app')

@section('title')@lang('site::event.events')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => $event_type->name,
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => $event_type->name]
        ]
    ])

@endsection
@section('content')
    <div class="container">
        @alert()@endalert()
        <div class="row">
            <div class="col-md-4">
                <img class="img-fluid" src="{!! $event_type->image->src() !!}"/>
            </div>
            <div class="col-md-8">
                {!! $event_type->description !!}
            </div>
        </div>
        <p class="card-text"></p>
        <div class="text-center mt-5 my-4">
            <p class="text-large my-4">@lang('site::event_type.request.region')</p>
            <p class="my-4">
                <a href="{{route('members.create', ['type_id' => $event_type->id])}}"
                   class="btn btn-ferroli">@lang('site::messages.leave') @lang('site::member.member')</a>
            </p>
            <p class="text-large my-4">@lang('site::event_type.request.city')</p>
        </div>
        @filter(['repository' => $repository, 'route_param' => $event_type])@endfilter
        @pagination(['pagination' => $events])@endpagination
        {{$events->render()}}
        @foreach($events as $event)
            <div class="card my-4" id="event-{{$event->id}}">
                <div class="card-header with-elements px-3">
                    <div class="card-header-elements">
                        <span class="bg-light font-weight-bold px-2 mr-2">
                            {{$event->date_from->format('d.m.Y')}}
                            @if($event->date_from->format('d.m.Y') != $event->date_to->format('d.m.Y'))
                                - {{$event->date_to->format('d.m.Y')}}
                            @endif
                        </span>
                        <a class="text-big mr-2" href="{{route('events.show', $event)}}">{{$event->title }}</a>
                        <span class="badge text-normal badge-pill text-white"
                              style="background-color: {{ $event->status->color }}">
                            <i class="fa fa-{{ $event->status->icon }}"></i> {{ $event->status->name }}
                        </span>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        @if( $event->members()->where('status_id', 2)->exists())
                            <span data-toggle="tooltip"
                                  data-placement="top"
                                  title="@lang('site::event.help.members')"
                                  class="badge badge-secondary text-normal badge-pill">
                                <i class="fa fa-@lang('site::member.icon')"></i> {{ $event->members()->where('status_id', 2)->count() }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">

                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::event.region_id')</dt>
                            <dd class="col-12">{{$event->region->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::event.place')</dt>
                            <dd class="col-12">{{$event->city}}, {{$event->address}}</dd>
                        </dl>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dd class="col-12">{!! $event->annotation !!}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dd class="col-12 text-left text-sm-right">
                                <a class="btn btn-sm btn-ferroli" href="{{route('members.register', $event)}}">@lang('site::event.register')</a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$events->render()}}
    </div>
@endsection