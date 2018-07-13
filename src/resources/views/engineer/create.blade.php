@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('engineers.index') }}">@lang('site::engineer.engineers')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::engineer.engineer')</h1>


        @alert()@endalert

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                <div class="card mt-2 mb-2">
                    <div class="card-body">

                        @include('site::engineer.form')

                        <div class="form-row">
                            <div class="col text-right">
                                <button name="_create" form="form-content" value="1" type="submit" class="btn btn-primary mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_add')</span>
                                </button>
                                <button name="_create" form="form-content" value="0" type="submit" class="btn btn-primary mb-1">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('engineers.index') }}" class="btn btn-secondary mb-1">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection