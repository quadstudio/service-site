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
            <li class="breadcrumb-item active">@lang('site::certificate.certificates')</li>
        </ol>
        <h1 class="header-title">
            <i class="fa fa-@lang('site::certificate.icon')"></i> @lang('site::certificate.certificates')
        </h1>
        @alert()@endalert
        <style>
            .certificate-name .btn-row-delete{
                opacity: .1;

            }
            .certificate-name:hover .btn-row-delete{
                opacity: 1;
            }
        </style>
        <div class=" border p-3 mb-2">
            <div class="dropdown d-inline-block">
                <button class="btn btn-ferroli dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-download"></i>
                    <span>@lang('site::messages.load') @lang('site::certificate.certificates')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($certificate_types as $certificate_type)
                        <a class="dropdown-item"
                           href="{{ route('admin.certificates.create', $certificate_type) }}">
                            {{$certificate_type->name}}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $certificates])@endpagination
        {{$certificates->render()}}
        @foreach($certificates as $certificate)
            <div class="card @if($loop->last) mb-2 @else my-2 my-sm-0 @endif"
                 id="certificate-{{$certificate->id}}">
                <form id="certificate-delete-form-{{$certificate->id}}"
                      action="{{route('admin.certificates.destroy', $certificate)}}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="row">
                    <div class="col-xl-3 col-sm-6 certificate-name">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">
                                <span class="text-big">№ {{$certificate->id}}</span>
                                <button class="pull-right btn btn-sm btn-danger btn-row-delete py-0"
                                        data-form="#certificate-delete-form-{{$certificate->id}}"
                                        data-btn-delete="@lang('site::messages.delete')"
                                        data-btn-cancel="@lang('site::messages.cancel')"
                                        data-label="@lang('site::messages.delete_confirm')"
                                        data-message="@lang('site::messages.delete_sure') @lang('site::certificate.certificate')? "
                                        data-toggle="modal" data-target="#form-modal"
                                        title="@lang('site::messages.delete')">
                                    <i class="fa fa-close"></i>
{{--                                    @lang('site::messages.delete')--}}
                                </button>
                            </dt>
                            <dd class="col-12">{{$certificate->type->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::certificate.name')</dt>
                            <dd class="col-12">{{$certificate->name}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            @if($certificate->organization)
                                <dt class="col-12">@lang('site::certificate.organization')</dt>
                                <dd class="col-12">{{$certificate->organization}}</dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        @if($certificate->engineer()->exists())
                            <dl class="dl-horizontal mt-2">
                                <dt class="col-12">@lang('site::user.header.user')</dt>
                                <dd class="col-12">
                                    <a href="{{route('admin.users.show', $certificate->engineer->user)}}">
                                        {{$certificate->engineer->user->name}}
                                    </a>
                                </dd>
                            </dl>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{$certificates->render()}}
    </div>
@endsection
