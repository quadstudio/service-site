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
                <a href="{{ route('admin.datasheets.index') }}">@lang('site::datasheet.datasheets')</a>
            </li>
            <li class="breadcrumb-item active">{{ $datasheet->name ?: $datasheet->file->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $datasheet->name ?: $datasheet->file->name }}</h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-success d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{route('files.show', $datasheet->file)}}">
                <i class="fa fa-download"></i>
                @lang('site::messages.download')
            </a>
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.datasheets.edit', $datasheet) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::datasheet.datasheet')</span>
            </a>
            <a href="{{route('admin.datasheets.products', $datasheet)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::product.icon')"></i>
                <span>@lang('site::datasheet.header.products')</span>
                <span class="badge badge-light datasheet-products-count">{{$datasheet->products()->count()}}</span>
            </a>
            <a href="{{ route('admin.datasheets.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.name')</dt>
                    <dd class="col-sm-8">{{$datasheet->name}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.type_id')</dt>
                    <dd class="col-sm-8">{{$datasheet->file->type->name}}</dd>



                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.date_from_to')</dt>
                    <dd class="col-sm-8">
                        @if(!is_null($datasheet->date_from))
                            @lang('site::datasheet.date_from') {{ \Carbon\Carbon::createFromFormat('Y-m-d', $datasheet->date_from)->format('d.m.Y') }}
                        @endif
                        @if(!is_null($datasheet->date_to))
                            @lang('site::datasheet.date_to') {{ \Carbon\Carbon::createFromFormat('Y-m-d', $datasheet->date_to)->format('d.m.Y') }}
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.tags')</dt>
                    <dd class="col-sm-8">{!! $datasheet->tags !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.active')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $datasheet->active])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.downloads')</dt>
                    <dd class="col-sm-8">{{$datasheet->file->downloads}} {{numberof($datasheet->file->downloads, 'раз', ['', 'а', ''])}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.name')</dt>
                    <dd class="col-sm-8">{!! $datasheet->file->name !!}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.storage')
                        / @lang('site::file.path')</dt>
                    <dd class="col-sm-8">{{Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix().$datasheet->file->path}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.mime')</dt>
                    <dd class="col-sm-8">{{$datasheet->file->mime}}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.size')</dt>
                    <dd class="col-sm-8">{{formatFileSize($datasheet->file->size)}} <span
                                class="text-muted">(@lang('site::file.real_size')
                            : {{formatFileSize(filesize(Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix().$datasheet->file->path))}}
                            )</span></dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.header.products')</dt>
                    <dd class="col-sm-8">
                        <div class="list-group">
                            @foreach($datasheet->products as $product)
                                <a href="{{route('admin.products.show', $product)}}"
                                   class="list-group-item list-group-item-action">
                                    {{$product->name}} ({{$product->type->name}})
                                </a>
                            @endforeach
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
