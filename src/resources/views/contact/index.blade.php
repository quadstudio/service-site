@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::contact.contacts')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::contact.icon')"></i> @lang('site::contact.contacts')</h1>

        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('contacts.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::contact.contact')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $contacts])@endpagination
        {{$contacts->render()}}

        @foreach($contacts as $contact)
            <div class="card my-4" id="contact-{{$contact->id}}">

                <div class="card-header with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('contacts.show', $contact)}}" class="mr-3">
                            {{$contact->name}}
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::phone.phones')</dt>
                            <dd class="col-12">
                                <ul class="list-group"></ul>
                                @foreach ($contact->phones()->with('country')->get() as $phone)
                                    <li class="list-group-item border-0 p-0">
                                        {{$phone->country->phone}}
                                        {{$phone->number}}
                                        @if($phone->extra)
                                            (@lang('site::phone.help.extra') {{$phone->extra}})
                                        @endif
                                    </li>
                                @endforeach
                            </dd>

                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            <dt class="col-12">@lang('site::contact.type_id')</dt>
                            <dd class="col-12">{{$contact->type->name}}</dd>
                        </dl>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            @if($contact->position)
                                <dt class="col-12">@lang('site::contact.position')</dt>
                                <dd class="col-12">{{$contact->position}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal my-sm-2 my-0">
                            @if($contact->web)
                                <dt class="col-12">@lang('site::contact.web')</dt>
                                <dd class="col-12">{{$contact->web}}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$contacts->render()}}
    </div>
@endsection
