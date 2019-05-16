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
                <a href="{{ route('admin.contacts.index') }}">@lang('site::contact.contacts')</a>
            </li>
            <li class="breadcrumb-item active">{{ $contact->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $contact->name }}</h1>
        @alert()@endalert()
        <div class=" border p-3 mb-2">

            <a href="{{ route('admin.contacts.edit', $contact) }}"
               class="@cannot('edit', $contact) disabled @endcannot d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">
                <i class="fa fa-pencil"></i>
                @lang('site::messages.edit')  @lang('site::contact.contact')
            </a>
            {{--<a href="{{route('admin.contacts.phones.create', $contact)}}"--}}
               {{--class="@cannot('phone', $contact) disabled @endcannot d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-ferroli">--}}
                {{--<i class="fa fa-plus"></i> @lang('site::messages.add') @lang('site::phone.phone')--}}
            {{--</a>--}}
            <button class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-danger btn-row-delete"
                    data-form="#contact-delete-form-{{$contact->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::contact.contact')? "
                    data-toggle="modal" data-target="#form-modal"
                    title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i>
                @lang('site::messages.delete')
            </button>

            <a href="{{ route('admin.contacts.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <form id="contact-delete-form-{{$contact->id}}"
              action="{{route('admin.contacts.destroy', $contact)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
        <div class="card mb-4">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.created_at')</dt>
                    <dd class="col-sm-8">{{ $contact->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contact.name')</dt>
                    <dd class="col-sm-8">{{ $contact->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contact.type_id')</dt>
                    <dd class="col-sm-8">{{ $contact->type->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::contact.position')</dt>
                    <dd class="col-sm-8">{{ $contact->position }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::phone.phones')</dt>
                    <dd class="col-sm-8">
                        <ul class="list-group list-group-flush"></ul>
                        @foreach ($contact->phones()->with('country')->get() as $phone)
                            <li class="list-group-item">
                                {{$phone->country->phone}}
                                {{$phone->number}}
                                @if($phone->extra)
                                    (@lang('site::phone.help.extra') {{$phone->extra}})
                                @endif

                                {{--<button @cannot('delete', $phone) disabled @endcannot--}}
                                {{--class="pull-right btn btn-sm btn-danger btn-row-delete py-0"--}}
                                        {{--data-form="#phone-delete-form-{{$phone->id}}"--}}
                                        {{--data-btn-delete="@lang('site::messages.delete')"--}}
                                        {{--data-btn-cancel="@lang('site::messages.cancel')"--}}
                                        {{--data-label="@lang('site::messages.delete_confirm')"--}}
                                        {{--data-message="@lang('site::messages.delete_sure') @lang('site::phone.phone')? "--}}
                                        {{--data-toggle="modal" data-target="#form-modal"--}}
                                        {{--title="@lang('site::messages.delete')">--}}
                                    {{--<i class="fa fa-close"></i>--}}
                                    {{--@lang('site::messages.delete')--}}
                                {{--</button>--}}
                                {{--<a href="{{route('admin.contacts.phones.edit', [$contact, $phone])}}"--}}
                                   {{--class="pull-right btn btn-ferroli btn-sm py-0 mx-1">--}}
                                    {{--<i class="fa fa-pencil"></i>--}}
                                    {{--@lang('site::messages.edit')--}}
                                {{--</a>--}}
                                {{--<form id="phone-delete-form-{{$phone->id}}"--}}
                                      {{--action="{{route('admin.contacts.phones.destroy', [$contact, $phone])}}"--}}
                                      {{--method="POST">--}}
                                    {{--@csrf--}}
                                    {{--@method('DELETE')--}}
                                {{--</form>--}}
                            </li>
                        @endforeach
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
