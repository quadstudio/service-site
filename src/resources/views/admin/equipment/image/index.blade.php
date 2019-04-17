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
                <a href="{{ route('admin.equipments.index') }}">@lang('site::equipment.equipments')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.equipments.show', $equipment) }}">{{$equipment->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::image.images')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::image.images')</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.equipments.show', $equipment) }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::equipment.help.back')</span>
            </a>
        </div>
        <div class="card mb-4 ">
            <div class="card-body">
                <form method="POST" id="form-content"
                      action="{{ route('admin.equipments.images.store', $equipment) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-row mt-2">
                                <div class="col">
                                    <label class="control-label" class="control-label"
                                           for="image_id">@lang('site::catalog.image_id')</label>
                                    <form method="POST" enctype="multipart/form-data"
                                          action="{{route('admin.images.store')}}">
                                        @csrf
                                        <input type="hidden"
                                               name="storage"
                                               value="equipments"/>
                                        <input class="d-inline-block form-control-file{{ $errors->has('path') ? ' is-invalid' : '' }}"
                                               type="file"
                                               accept="{{config('site.catalogs.accept')}}"
                                               name="path"/>

                                        <input type="button" class="btn btn-ferroli d-inline-block image-upload-button"
                                               value="@lang('site::messages.load')"/>
                                        <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">

                            <div id="images"
                                 class="form-row my-2 sort-list"
                                 data-target="{{route('admin.images.sort')}}">
                                @foreach($images as $image)
                                    @include('site::admin.image.edit')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
