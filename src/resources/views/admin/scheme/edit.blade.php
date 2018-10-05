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
                        <form method="POST" id="scheme-edit-form"
                              action="{{ route('admin.schemes.update', $scheme) }}">

                            @csrf

                            @method('PUT')

                            <div class="form-group required">
                                <label class="control-label"
                                       for="datasheet_id">@lang('site::scheme.datasheet_id')</label>
                                <select class="form-control{{  $errors->has('datasheet_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="datasheet_id"
                                        id="datasheet_id">
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                    @foreach($datasheets as $datasheet)
                                        <option data-cost="{{$datasheet->cost}}"
                                                @if(old('datasheet_id', $scheme->datasheet_id) == $datasheet->id) selected
                                                @endif
                                                value="{{ $datasheet->id }}">{{ $datasheet->file->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('datasheet_id') }}</span>
                            </div>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="block_id">@lang('site::scheme.block_id')</label>
                                <select class="form-control{{  $errors->has('block_id') ? ' is-invalid' : '' }}"
                                        required
                                        name="block_id"
                                        id="block_id">
                                    <option value="">@lang('site::messages.select_from_list')</option>
                                    @foreach($blocks as $block)
                                        <option data-cost="{{$block->cost}}"
                                                @if(old('block_id', $scheme->block_id) == $block->id) selected
                                                @endif
                                                value="{{ $block->id }}">{{ $block->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback">{{ $errors->first('block_id') }}</span>
                            </div>

                            <div class="form-group required">
                                <label class="control-label"
                                       for="image_id">@lang('site::scheme.image_id')</label>

                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.schemes.image')}}">
                                    @csrf
                                    <input type="hidden" name="storage" value="schemes"/>
                                    <input class="d-inline-block form-control-file{{ $errors->has('image_id') ? ' is-invalid' : '' }}"
                                           type="file"
                                           name="path"/>

                                    <input type="button" class="btn btn-ferroli image-upload-button"
                                           value="@lang('site::messages.load')"/>
                                    <span class="invalid-feedback">{{ $errors->first('image_id') }}</span>
                                </form>

                                <div id="image-src" class="bg-light"
                                     style="width: {{config('site.schemes.size.image.width', 740)}}px;height: {{config('site.schemes.size.image.height', 1000)}}px;">
                                    @include('site::admin.scheme.image', ['image'   => $scheme->image])
                                </div>

                            </div>

                            <hr />
                            <div class=" text-right">
                                <button name="_stay" form="scheme-edit-form" value="1" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save_stay')</span>
                                </button>
                                <button name="_stay" form="scheme-edit-form" value="0" type="submit" class="btn btn-ferroli">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('site::messages.save')</span>
                                </button>
                                <a href="{{ route('admin.schemes.index') }}" class="d-block d-sm-inline btn btn-secondary">
                                    <i class="fa fa-close"></i>
                                    <span>@lang('site::messages.cancel')</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
