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
            <li class="breadcrumb-item active">@lang('site::datasheet.datasheets')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::datasheet.icon')"></i> @lang('site::datasheet.datasheets')</h1>

        @alert()@endalert

        <div class="justify-content-start border p-3 mb-2">
            <a class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('admin.datasheets.create') }}"
               role="button">
                <i class="fa fa-plus"></i>
                <span>@lang('site::messages.add') @lang('site::datasheet.datasheet')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $datasheets])@endpagination
        {{$datasheets->render()}}
        @foreach($datasheets as $datasheet)
            <div class="card my-1" id="datasheet-{{$datasheet->id}}">
                <div class="row">
                    <div class="col-xl-6 col-sm-6">
                        <dl class="dl-horizontal mt-2 mb-0">
                            <dd class="col-12">
                                <a href="{{route('admin.datasheets.show', $datasheet)}}" class="text-big mr-3 ml-0">
                                    {{ $datasheet->name ?: $datasheet->file->name }}
                                </a>
                            </dd>
                            <dd class="col-12 text-muted">
                                {{ $datasheet->file->type->name }}
                                {{ $datasheet->date }}
                            </dd>

                            {{--<dd class="col-12">{{$datasheet->date_trade->format('d.m.Y')}}</dd>--}}
                            {{--<dt class="col-12">@lang('site::datasheet.date_datasheet')</dt>--}}
                            {{--<dd class="col-12">{{$datasheet->date_datasheet->format('d.m.Y')}}</dd>--}}
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0 mb-0 text-center text-sm-right">
                            <dd>
                                @if( $datasheet->file->downloads > 0)
                                    <span data-toggle="tooltip"
                                          data-placement="top"
                                          title="@lang('site::file.downloads')"
                                          class="badge badge-secondary text-normal badge-pill">
                                        <i class="fa fa-download"></i> {{$datasheet->file->downloads}}
                                    </span>
                                @endif
                                @if( $datasheet->products()->count() > 0)
                                    <span data-toggle="tooltip"
                                          data-placement="top"
                                          title="@lang('site::datasheet.header.products')"
                                          class="badge badge-secondary text-normal badge-pill">
                                        <i class="fa fa-chain"></i> {{$datasheet->products()->count()}}
                                    </span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2 mb-0 text-center text-sm-right">
                            <dd class="col-12">
                                @if($datasheet->file->exists())
                                    @include('site::file.download', ['file' => $datasheet->file, 'small' => true])
                                @else
                                    <span class="badge badge-danger text-big">@lang('site::file.error.not_found')</span>
                                @endif
                            </dd>

                            {{--<dt class="col-12">@lang('site::datasheet.date_trade')</dt>--}}
                            {{--<dd class="col-12">{{$datasheet->date_trade->format('d.m.Y')}}</dd>--}}
                            {{--<dt class="col-12">@lang('site::datasheet.date_datasheet')</dt>--}}
                            {{--<dd class="col-12">{{$datasheet->date_datasheet->format('d.m.Y')}}</dd>--}}
                        </dl>

                    </div>
                </div>
            </div>
        @endforeach
        {{$datasheets->render()}}
    </div>
@endsection
