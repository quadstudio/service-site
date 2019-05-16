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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.events.index') }}">@lang('site::event.events')</a>
            </li>
            <li class="breadcrumb-item active">{{ $event->title }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $event->title }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">

            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.events.edit', $event) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::event.event')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.members.create', ['event_id' => $event->id]) }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::member.member')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.events.mailing', $event) }}"
               role="button">
                <i class="fa fa-envelope"></i>
                <span>@lang('site::messages.create') @lang('site::mailing.mailing')</span>
            </a>
            <button
                    @cannot('delete', $event) disabled @endcannot
            class="btn btn-danger btn-row-delete"
                    data-form="#event-delete-form-{{$event->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::event.event')? "
                    data-toggle="modal" data-target="#form-modal"
                    href="javascript:void(0);" title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i>
                @lang('site::messages.delete')
            </button>
            <a href="{{ route('admin.events.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <form id="event-delete-form-{{$event->id}}"
              action="{{route('admin.events.destroy', $event)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_ferroli')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $event->show_ferroli])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_lamborghini')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $event->show_lamborghini])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.title')</dt>
                    <dd class="col-sm-8">{{$event->title}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.annotation')</dt>
                    <dd class="col-sm-8">{!! $event->annotation !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.type_id')</dt>
                    <dd class="col-sm-8">{{$event->type->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.status_id')</dt>
                    <dd class="col-sm-8">{{$event->status->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.region_id')</dt>
                    <dd class="col-sm-8">{{$event->region->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.city')</dt>
                    <dd class="col-sm-8">{{$event->city}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.address')</dt>
                    <dd class="col-sm-8">{{$event->address}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.date')</dt>
                    <dd class="col-sm-8">
                        @lang('site::messages.date_from') {{ $event->date_from->format('d.m.Y') }}
                        @lang('site::messages.date_to') {{ $event->date_to->format('d.m.Y') }}
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.confirmed')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $event->confirmed])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.description')</dt>
                    <dd class="col-sm-8">{!! $event->description !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.image_id')</dt>
                    <dd class="col-sm-8">
                        @include('site::admin.image.preview', ['image' => $event->image])
                    </dd>
                </dl>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="members-tab" data-toggle="tab"
                   href="#members" role="tab" aria-controls="home" aria-selected="true">
                    @lang('site::member.members')
                    <span class="badge badge-ferroli text-normal">
                        {{ $event->members()->count() }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="participants-tab" data-toggle="tab"
                   href="#participants" role="tab" aria-controls="profile" aria-selected="false">
                    @lang('site::participant.participants')
                    <span class="badge badge-ferroli text-normal">
                        {{ $event->members->sum(function ($member) {
                            return $member->participants()->count();
                        }) }}
                    </span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content mb-4">
            <div class="tab-pane active" id="members" role="tabpanel" aria-labelledby="members-tab">
                @foreach($event->members as $member)
                    <div class="card my-1" id="member-{{$member->id}}">

                        <div class="card-header with-elements px-3">
                            <div class="card-header-elements">
                                <span class="bg-light font-weight-bold px-2 mr-2">
                                    {{$event->date_from->format('d.m.Y')}}
                                    @if($event->date_from->format('d.m.Y') != $event->date_to->format('d.m.Y'))
                                        - {{$event->date_to->format('d.m.Y')}}
                                    @endif
                                </span>
                                <a href="{{route('admin.members.show', $member)}}" class=" text-big mr-2 ml-0">
                                    {{$member->name}}
                                </a>
                                <span data-toggle="tooltip"
                                      data-placement="top"
                                      title="@lang('site::member.status_id')"
                                      class="badge text-normal badge-pill badge-{{ $member->status->color }} mr-3 ml-0">
                                    <i class="fa fa-{{ $member->status->icon }}"></i> {{ $member->status->name }}
                                </span>
                            </div>
                            <div class="card-header-elements ml-md-auto">
                            <span data-toggle="tooltip"
                                  data-placement="top"
                                  title="@lang('site::member.type_id')"
                                  class="px-2 bg-light text-big">{{$member->type->name}}</span>
                                @if( $member->count > 0)
                                    <span data-toggle="tooltip"
                                          data-placement="top"
                                          title="@lang('site::member.count')"
                                          class="badge badge-secondary text-normal badge-pill">
                                        <i class="fa fa-@lang('site::participant.icon')"></i> {{ $member->count }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6">
                                    <dl class="dl-horizontal mt-0 mt-sm-2">
                                        {{--                                <dt class="col-12">@lang('site::member.contact')</dt>--}}
                                        <dd data-toggle="tooltip"
                                            data-placement="top"
                                            title="@lang('site::member.contact')"
                                            class="col-12"><i class="fa fa-user"></i> {{$member->contact}}</dd>
                                        <dd data-toggle="tooltip"
                                            data-placement="top"
                                            title="@lang('site::member.phone')"
                                            class="col-12"><i class="fa fa-phone"></i> {{$member->phoneNumber}}</dd>
                                        <dd data-toggle="tooltip"
                                            data-placement="top"
                                            title="@lang('site::member.verified_'.(int)$member->verified)"
                                            class="col-12 @if($member->verified == 0) text-danger @else text-success @endif">
                                            <i class="fa fa-envelope"></i> {{$member->email}}</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <dl class="dl-horizontal mt-0 mt-sm-2">
                                        <dt class="col-12">@lang('site::member.region_id')</dt>
                                        <dd class="col-12">{{$member->region->name}}</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <dl class="dl-horizontal mt-0 mt-sm-2">
                                        <dt class="col-12">@lang('site::member.city')</dt>
                                        <dd class="col-12">{{$member->city}}</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <dl class="dl-horizontal mt-0 mt-sm-2">
                                        <dd class="col-12">
                                            @bool(['bool' => $member->show_ferroli])@endbool
                                            @lang('site::messages.show_ferroli')
                                        </dd>
                                        <dd class="col-12">
                                            @bool(['bool' => $member->show_lamborghini])@endbool
                                            @lang('site::messages.show_lamborghini')
                                        </dd>
                                    </dl>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tab-pane" id="participants" role="tabpanel" aria-labelledby="participants-tab">
                @foreach($event->members as $member)
                    @foreach($member->participants as $participant)
                        <div class="card my-0 border-top-0 border-bottom" id="participant-{{$participant->id}}">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6">
                                        <dl class="dl-horizontal mt-0 mt-sm-2">
                                            {{--                                            <dt class="col-12">@lang('site::participant.name')</dt>--}}
                                            <dd class="col-12">{{$participant->name}}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <dl class="dl-horizontal mt-0 mt-sm-2">
                                            {{--                                            <dt class="col-12">@lang('site::participant.headposition')</dt>--}}
                                            <dd class="col-12">{{$participant->headposition}}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        @if($participant->phone)
                                            <dl class="dl-horizontal mt-0 mt-sm-2">
                                                {{--                                                <dt class="col-12">@lang('site::participant.phone')</dt>--}}
                                                <dd class="col-12">{{$participant->phoneNumber}}</dd>
                                            </dl>
                                        @endif
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        @if($participant->email)
                                            <dl class="dl-horizontal mt-0 mt-sm-2">
                                                {{--                                                <dt class="col-12">@lang('site::participant.email')</dt>--}}
                                                <dd class="col-12">{{$participant->email}}</dd>
                                            </dl>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
