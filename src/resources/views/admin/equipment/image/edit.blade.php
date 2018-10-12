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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.equipments.images.update', $equipment) }}">
                            @csrf
                            @method('PUT')
                        </form>

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h5 class="card-title">@lang('site::image.images')</h5>
                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('admin.equipments.images.store', $equipment)}}">
                                    @csrf
                                    <div class="form-group form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                                        <input type="file" name="path"/>
                                        <input type="hidden" name="storage" value="products"/>
                                        <input type="button" class="btn btn-ferroli image-upload-button"
                                               value="@lang('site::messages.load')">

                                    </div>
                                    <span class="invalid-feedback">{{ $errors->first('path') }}</span>
                                </form>
                                <form method="post" id="delete-form"
                                      action="{{ route('admin.equipments.images.destroy', $equipment) }}">
                                    @csrf
                                    @method('DELETE')
                                    <table class="table">
                                        <tbody data-target="{{route('admin.equipments.images.sort', $equipment)}}"
                                               id="sort-list">
                                        @each('site::admin.image.edit', $images, 'image')
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class=" border p-3 mt-2 mb-4 text-right">
            {{--<a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0" href="{{ route('products.create') }}"--}}
            {{--role="button">--}}
            {{--<i class="fa fa-plus"></i>--}}
            {{--<span>@lang('site::messages.add') @lang('site::product.product')</span>--}}
            {{--</a>--}}
            <button  form="delete-form" type="submit" class="btn btn-danger mr-1">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.delete')</span>
            </button>
            {{--<button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">--}}
                {{--<i class="fa fa-check"></i>--}}
                {{--<span>@lang('site::messages.save_stay')</span>--}}
            {{--</button>--}}
            {{--<button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">--}}
                {{--<i class="fa fa-check"></i>--}}
                {{--<span>@lang('site::messages.save')</span>--}}
            {{--</button>--}}
            <a href="{{ route('admin.equipments.show', $equipment) }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>
        </div>
    </div>
@endsection
