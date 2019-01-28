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
                <a href="{{ route('admin.members.index') }}">@lang('site::member.members')</a>
            </li>
            <li class="breadcrumb-item active">{{ $member->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $member->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">

            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.members.edit', $member) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::member.member')</span>
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.participants.create', $member) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::participant.help.list')</span>
            </a>
            <a class="btn @cannot('event', $member) disabled @endcannot btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.events.create', $member) }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.create') @lang('site::event.event')</span>
            </a>
            <a href="{{ route('admin.members.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.id')</dt>
                    <dd class="col-sm-8">{{$member->id}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.status_id')</dt>
                    <dd class="col-sm-8">{{$member->status->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.event_id')</dt>
                    <dd class="col-sm-8">
                        <a href="{{route('admin.events.show', $member->event)}}">{{$member->event->title}}</a>
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.name')</dt>
                    <dd class="col-sm-8">{{$member->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.type_id')</dt>
                    <dd class="col-sm-8">{{$member->type->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.region_id')</dt>
                    <dd class="col-sm-8">{{$member->region->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.city')</dt>
                    <dd class="col-sm-8">{{$member->city}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.address')</dt>
                    <dd class="col-sm-8">{{$member->address}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.header.date_from_to')</dt>
                    <dd class="col-sm-8">
                        @lang('site::member.date_from') {{ $member->date_from() }}
                        @lang('site::member.date_to') {{ $member->date_to() }}
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.email')</dt>
                    <dd class="col-sm-8">{{$member->email}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.verified')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $member->verified])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.phone')</dt>
                    <dd class="col-sm-8">{{$member->phone}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::member.count')</dt>
                    <dd class="col-sm-8">{{$member->count}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::participant.participants')</dt>
                    <dd class="col-sm-8">
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th>@lang('site::participant.name')</th>
                                <th>@lang('site::participant.headposition')</th>
                                <th>@lang('site::participant.phone')</th>
                                <th>@lang('site::participant.email')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($member->participants as $participant)
                                <tr>
                                    <td>{{$participant->name}}</td>
                                    <td>{{$participant->headposition}}</td>
                                    <td>{{$participant->phone}}</td>
                                    <td>{{$participant->email}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </dd>

                </dl>


            </div>
        </div>
    </div>
@endsection
