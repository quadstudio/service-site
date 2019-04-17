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
                    class=" btn btn-danger btn-row-delete"
                    data-form="#event-delete-form-{{$event->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::event.event')? "
                    data-toggle="modal" data-target="#form-modal"
                    href="javascript:void(0);" title="@lang('site::messages.delete')">
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

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::event.date_from_to')</dt>
                    <dd class="col-sm-8">
                        @lang('site::event.date_from') {{ $event->date_from->format('d.m.Y') }}
                        @lang('site::event.date_to') {{ $event->date_to->format('d.m.Y') }}
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
                <h4 class="mb-2">@lang('site::member.members')</h4>
                <table class="table bg-white table-hover">
                    <thead>
                    <tr>
                        <th>@lang('site::member.name')</th>
                        <th>@lang('site::member.type_id')</th>
                        <th>@lang('site::member.header.date_from_to')</th>
                        <th>@lang('site::member.event_id')</th>
                        <th>@lang('site::member.contact')</th>
                        <th>@lang('site::member.region_id')</th>
                        <th>@lang('site::member.city')</th>
                        <th class="text-center">@lang('site::member.count')</th>
                        <th class="text-center">@lang('site::member.confirmed')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($event->members as $member)
                        @include('site::admin.member.index.row')
                    @endforeach
                    </tbody>
                </table>
				
				<h4 class="mb-2">@lang('site::participant.participants')</h4>
                    
                        <table class="table table-sm table-hover">
                            <thead><tr><th>@lang('site::participant.name')</th><th>@lang('site::participant.headposition')</th><th>@lang('site::participant.phone')</th><th>@lang('site::participant.email')</th></tr></thead>
                            <tbody>
                            
							@foreach($event->members as $member)
							@foreach($member->participants as $participant)
                                <tr><td>{{$participant->name}}</td><td>{{$participant->headposition}}</td><td>{{$participant->phone}}</td><td>{{$participant->email}}</td></tr>
                            @endforeach
							@endforeach
                            </tbody>
                        </table>
                    
				
            </div>
        </div>
    </div>
@endsection
