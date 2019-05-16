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
            <li class="breadcrumb-item active">@lang('site::contact.contacts')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts')
        </h1>

        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contacts])@endpagination
        {{$contacts->render()}}

        @foreach($contacts as $contact)
            <div class="card my-1" id="contact-{{$contact->id}}">

                <div class="row">
                    <div class="col-xl-4">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dd class="col-12 py-1">
                                <a href="{{route('admin.contacts.show', $contact)}}" class="text-big">
                                    {{$contact->name}}
                                </a>
                            </dd>
                            @if($contact->position)
                                <dd class="col-12 text-muted">{{$contact->position}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-4">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contact.type_id')</dt>
                            <dd class="col-12">
                                {{$contact->type->name}}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-4">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contact.user_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('admin.users.show', $contact->user)}}">
                                    {{$contact->user->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
        @endforeach
        {{$contacts->render()}}
    </div>
@endsection
