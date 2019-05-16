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

            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.datasheets.edit', $datasheet) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit') @lang('site::datasheet.datasheet')</span>
            </a>
            <a href="{{route('admin.datasheets.products.index', $datasheet)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::product.icon')"></i>
                <span>@lang('site::datasheet.header.products')</span>
                <span class="badge badge-light datasheet-products-count">{{$datasheet->products()->count()}}</span>
            </a>
            @if($datasheet->file->exists())
                <a class="btn btn-success d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
                   href="{{route('files.show', $datasheet->file)}}">
                    <i class="fa fa-download"></i>
                    @lang('site::messages.download')
                </a>
            @endif
            <a href="{{ route('admin.datasheets.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>

        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <dl class="row">

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_ferroli')</dt>
                            <dd class="col-sm-8">@bool(['bool' => $datasheet->show_ferroli])@endbool</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::messages.show_lamborghini')</dt>
                            <dd class="col-sm-8">@bool(['bool' => $datasheet->show_lamborghini])@endbool</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.active')</dt>
                            <dd class="col-sm-8">@bool(['bool' => $datasheet->active])@endbool</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.name')</dt>
                            <dd class="col-sm-8">{{$datasheet->name}}</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.type_id')</dt>
                            <dd class="col-sm-8">{{$datasheet->file->type->name}}</dd>


                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.date_from_to')</dt>
                            <dd class="col-sm-8">
                                @if(!is_null($datasheet->date_from))
                                    @lang('site::messages.date_from') {{ $datasheet->date_from->format('d.m.Y') }}
                                @endif
                                @if(!is_null($datasheet->date_to))
                                    @lang('site::messages.date_to') {{ $datasheet->date_to->format('d.m.Y') }}
                                @endif
                            </dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.tags')</dt>
                            <dd class="col-sm-8">{!! $datasheet->tags !!}</dd>



                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.downloads')</dt>
                            <dd class="col-sm-8">{{$datasheet->file->downloads}} {{numberof($datasheet->file->downloads, 'раз', ['', 'а', ''])}}</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.name')</dt>
                            <dd class="col-sm-8">{!! $datasheet->file->name !!}</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.storage')
                                / @lang('site::file.path')</dt>
                            <dd class="col-sm-8">
                                {{Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix().$datasheet->file->path}}
                                @if(!$datasheet->file->exists())
                                    <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.mime')</dt>
                            <dd class="col-sm-8">{{$datasheet->file->mime}}</dd>

                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::file.size')</dt>
                            <dd class="col-sm-8">{{formatFileSize($datasheet->file->size)}}
                                @if($datasheet->file->exists())
                                    <span class="text-muted">(@lang('site::file.real_size'):
                                        {{formatFileSize(filesize(Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix().$datasheet->file->path))}}
                                        )
                            </span>
                                @endif
                            </dd>
                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.header.schemes')</dt>
                            <dd class="col-sm-8">
                                <div class="list-group">
                                    @foreach($datasheet->schemes as $scheme)
                                        <a href="{{route('admin.schemes.show', $scheme)}}"
                                           class="p-1 list-group-item list-group-item-action">
                                            {{$scheme->block->name}}
                                        </a>
                                    @endforeach
                                    <a href="{{route('admin.schemes.create', ['datasheet_id' => $datasheet->id])}}"
                                       class="p-1 list-group-item">
                                        <i class="fa fa-magic"></i>&nbsp;@lang('site::messages.create')
                                        &nbsp;@lang('site::scheme.scheme')
                                    </a>
                                </div>
                            </dd>
                            <dt class="col-sm-4 text-left text-sm-right">@lang('site::datasheet.header.products')</dt>
                            <dd class="col-sm-8">
                                <div class="list-group">
                                    @foreach($datasheet->products as $product)
                                        <a href="{{route('admin.products.show', $product)}}"
                                           class="p-1 list-group-item list-group-item-action">
                                            {{$product->name}} ({{$product->type->name}})
                                        </a>
                                    @endforeach
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        @if($datasheet->file)
                            <object style="width: 100%; height:100%" data="{{$datasheet->file->src()}}" type="{{$datasheet->file->mime}}">
                                <iframe src="https://docs.google.com/viewer?url={{$datasheet->file->src()}}&embedded=true"></iframe>
                            </object>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
