@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::event.events')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::event.icon')"></i> @lang('site::event.events')</h1>

        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.events.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::event.event')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $events])@endpagination
        {{$events->render()}}
        @foreach($events as $event)
            <div class="card my-2" id="event-{{$event->id}}">
                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <span class="bg-light px-2 mr-2">
                            {{$event->date_from->format('d.m.Y')}}
                            @if($event->date_from->ne($event->date_to))
                                -&nbsp;{{$event->date_to->format('d.m.Y')}}
                            @endif
                        </span>
                        <a href="{{route('admin.events.show', $event)}}" class="mr-2 ml-0">
                            {{$event->title}}
                        </a>
                        <span class="badge text-normal badge-pill text-white mr-3 ml-0"
                              style="background-color: {{ $event->status->color }}">
                            <i class="fa fa-{{ $event->status->icon }}"></i> {{ $event->status->name }}
                        </span>
                    </div>
                    <div class="card-header-elements ml-md-auto">
                        @component('site::components.bool.pill', ['bool' => $event->confirmed])
                            @lang('site::event.confirmed')
                        @endcomponent
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-sm-12">
                        @if($event->image()->exists())
                            <div class="row p-2">
                                <div class="col">@include('site::admin.image.preview', ['image' => $event->image])</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">{{$event->type->name}}</dt>
                            <dd class="col-12">
                                {{$event->members()->count()}}
                                {{numberof($event->members()->count(), trans('site::member.plural.text'), trans('site::member.plural.ending'))}}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::event.region_id')</dt>
                            <dd class="col-12">{{$event->region->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::event.address')</dt>
                            <dd class="col-12">
                                {{$event->city}}
                                @if($event->hasAddress()), {{$event->address}} @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$events->render()}}
    </div>
@endsection
