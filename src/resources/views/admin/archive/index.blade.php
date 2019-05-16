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
            <li class="breadcrumb-item active">@lang('site::archive.archives')</li>
        </ol>
        <h1 class="header-title mb-4">
            <i class="fa fa-@lang('site::archive.icon')"></i> @lang('site::archive.archives')
        </h1>
        @alert()@endalert
        <div class="justify-content-start border p-3 mb-2">
            <a href="{{ route('admin.currencies.index') }}" class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::currency.icon')"></i>
                <span>@lang('site::currency.currencies')</span>
            </a>
            <a href="{{ route('currencies.refresh') }}" class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-refresh"></i>
                <span>@lang('site::messages.refresh') @lang('site::archive.archive')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $archives])@endpagination
        {{$archives->render()}}
        @foreach($archives->groupBy(function($item){
            return $item->date->format('Y-m-d');
        }) as $date => $rows)
            <div class="card mb-1">
                <div class="card-body p-1">
                    @foreach($rows as $archive)
                        <div class="row">
                            <div class="col-4 text-center">
                                {{\Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d.m.Y')}}
                            </div>
                            <div class="col-4 text-center">
                                {{ $archive->rates }}
                            </div>
                            <div class="col-4 text-center">
                                <a href="{{route('admin.currencies.show', $archive->currency)}}">{{ $archive->currency->title }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        {{$archives->render()}}
    </div>
@endsection
