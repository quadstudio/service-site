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

        <div class=" border p-3 mb-2">
            
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
{{$certificate->type->name}} <br />
{{$certificate->id}}         <br />
{{$certificate->name}}       <br />
@if($certificate->organization)
<br />                                @lang('site::certificate.organization') {{$certificate->organization}}
@endif
@if($certificate->engineer()->exists())

@lang('site::user.header.user')     <a href="{{route('admin.users.show', $certificate->engineer->user)}}">
                                        {{$certificate->engineer->user->name}}
                                    </a>
                                
@endif
    </div>
@endsection
