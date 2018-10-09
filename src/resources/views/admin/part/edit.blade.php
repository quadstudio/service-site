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
                <a href="{{ route('admin.repairs.index') }}">@lang('site::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.repairs.show', $part->repair) }}">{{$part->repair->id}}</a>
            </li>
            <li class="breadcrumb-item">@lang('site::part.parts')</li>
            <li class="breadcrumb-item active">{{$part->product->name}}</li>
        </ol>
        <h1 class="header-title mb-4">{{$part->product->name}}</h1>

        @alert()@endalert

        <div class="card mb-5">
            <div class="card-body">

                <form id="form-content" method="POST" action="{{ route('admin.parts.update', $part) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row required">
                        <div class="col">

                            <label class="control-label"
                                   for="count">@lang('site::part.count')</label>
                            <input name="count"
                                   placeholder="@lang('site::part.count')"
                                   class="form-control"
                                   type="number" min="1" max="3" maxlength="1" title=""
                                   value="{{old('count', $part->count)}}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('count') }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-row required">
                        <div class="col">

                            <label class="control-label"
                                   for="cost">@lang('site::part.cost')</label>
                            <input name="cost"
                                   placeholder="@lang('site::part.cost')"
                                   class="form-control"
                                   type="number" min="1" step="1" title=""
                                   value="{{old('cost', $part->cost)}}">
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('cost') }}</strong>
                            </span>
                        </div>
                    </div>
                </form>

                <hr/>
                <div class=" mb-2 text-right">
                    <button form="form-content" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.repairs.show', $part->repair_id) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection