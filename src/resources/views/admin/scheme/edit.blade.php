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
                <a href="{{ route('admin.schemes.index') }}">@lang('site::scheme.schemes')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.schemes.show', $scheme) }}">{{$scheme->block->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.edit')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.edit') {{$scheme->block->name}}</h1>
        @alert()@endalert
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="form"
                              action="{{ route('admin.schemes.update', $scheme) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group required">
                                <label class="control-label"
                                       for="datasheet_id">@lang('site::scheme.datasheet_id')</label>
                                <select class="form-control{{  $errors->has('scheme.datasheet_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="scheme[datasheet_id]"
                                        id="datasheet_id">
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                    @foreach($datasheets as $datasheet)
                                        <option data-cost="{{$datasheet->cost}}"
                                                @if(old('scheme.datasheet_id', $scheme->datasheet_id) == $datasheet->id) selected
                                                @endif
                                                value="{{ $datasheet->id }}">{{ $datasheet->file->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('scheme.datasheet_id') }}</span>
                            </div>
                            <div class="form-group required">
                                <label class="control-label"
                                       for="block_id">@lang('site::scheme.block_id')</label>
                                <select class="form-control{{  $errors->has('scheme.block_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="scheme[block_id]"
                                        id="block_id">
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                    @foreach($blocks as $block)
                                        <option data-cost="{{$block->cost}}"
                                                @if(old('scheme.block_id', $scheme->block_id) == $block->id) selected
                                                @endif
                                                value="{{ $block->id }}">{{ $block->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('scheme.block_id') }}</span>
                            </div>
                        </form>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-row mt-2">
                                    <div class="col">
                                        <label class="control-label" class="control-label"
                                               for="image_id">@lang('site::scheme.image_id')</label>

                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{route('admin.images.store')}}">
                                            @csrf
                                            <input type="hidden"
                                                   name="storage"
                                                   value="schemes"/>
                                            <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                                   type="file"
                                                   accept="{{config('site.schemes.accept')}}"
                                                   name="path"/>

                                            <input type="button" class="btn btn-ferroli image-upload-button"
                                                   value="@lang('site::messages.load')"/>
                                            <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="images" class="row bg-white">
                                    @include('site::admin.image.edit')
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class=" text-right">
                            <button form="form" type="submit" class="btn btn-ferroli">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.save')</span>
                            </button>
                            <a href="{{ route('admin.schemes.index') }}" class="d-block d-sm-inline btn btn-secondary">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
