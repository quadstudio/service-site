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
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::scheme.scheme')</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">
                <form id="form-content" method="POST" action="{{ route('admin.schemes.store') }}">
                    @csrf

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
                                        @if(old('datasheet_id', request('datasheet_id')) == $datasheet->id) selected
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
                                        @if(old('block_id') == $block->id) selected
                                        @endif
                                        value="{{ $block->id }}">{{ $block->name }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">{{ $errors->first('block_id') }}</span>
                    </div>

                </form>

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
                    </div>

                </div>

                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_create" form="form-content" value="1" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_add')</span>
                        </button>
                        <button name="_create" form="form-content" value="0" type="submit" class="btn btn-ferroli mb-1">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.schemes.index') }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection