@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storehouses.index') }}">@lang('site::storehouse.storehouses')</a>
            </li>
            <li class="breadcrumb-item active">{{ $storehouse->name }}</li>
        </ol>
        <h1 class="header-title mb-4">{{ $storehouse->name }}</h1>
        @alert()@endalert()
        <div class="justify-content-start border p-3 mb-2">
            <a class="@cannot('edit', $storehouse) disabled @endcannot btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('storehouses.edit', $storehouse) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            <button @cannot('delete', $storehouse) disabled @endcannot
            class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-danger btn-row-delete"
                    data-form="#contact-delete-form-{{$storehouse->id}}"
                    data-btn-delete="@lang('site::messages.delete')"
                    data-btn-cancel="@lang('site::messages.cancel')"
                    data-label="@lang('site::messages.delete_confirm')"
                    data-message="@lang('site::messages.delete_sure') @lang('site::storehouse.storehouse')? "
                    data-toggle="modal" data-target="#form-modal"
                    title="@lang('site::messages.delete')">
                <i class="fa fa-close"></i>
                @lang('site::messages.delete')
            </button>

            <a href="{{ route('storehouses.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <form id="contact-delete-form-{{$storehouse->id}}"
              action="{{route('storehouses.destroy', $storehouse)}}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
        <div class="card mb-2">
            <div class="card-body">
                <dl class="row mb-0">

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.name')</dt>
                    <dd class="col-sm-8">{{ $storehouse->name }}</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.enabled')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $storehouse->enabled])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.everyday')</dt>
                    <dd class="col-sm-8">@bool(['bool' => $storehouse->everyday])@endbool</dd>

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.help.addresses')</dt>
                    @if($storehouse->addresses()->exists())
                        <dd class="col-sm-8">
                            <div class="list-group">
                                @foreach($storehouse->addresses as $address)
                                    <a href="{{route('addresses.show', $address)}}"
                                       class="list-group-item list-group-item-action p-1">
                                        <i class="fa fa-@lang('site::address.icon')"></i> {{ $address->full }}
                                    </a>
                                @endforeach
                            </div>
                        </dd>
                    @else
                        <dd class="col-8 text-danger">@lang('site::messages.no')</dd>
                    @endif


                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.help.products')</dt>
                    @if($storehouse->products()->exists())
                        <dd class="col-8">{{ $storehouse->products()->count() }}</dd>
                    @else
                        <dd class="col-8 text-danger">@lang('site::messages.no')</dd>
                    @endif

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.uploaded_at')</dt>
                    @if($storehouse->uploaded_at)
                        <dd class="col-8">{{$storehouse->uploaded_at->format('d.m.Y H:i')}}</dd>
                    @else
                        <dd class="col-8 text-danger">@lang('site::messages.never')</dd>
                    @endif

                    <dt class="col-sm-4 text-left text-sm-right">@lang('site::storehouse.header.upload')</dt>
                    <dd class="col-sm-8">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="scheduler-border">
                                    <legend>@lang('site::storehouse_product.upload.excel')</legend>
                                    <form enctype="multipart/form-data"
                                          action="{{route('storehouses.excel.store', $storehouse)}}" method="post">
                                        @csrf

                                        <div class="form-group mb-0">
                                            <input type="file"
                                                   name="path"
                                                   accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                   class="form-control-file{{  $errors->has('path') ? ' is-invalid' : '' }}"
                                                   id="path">
                                            <button type="submit" class="btn btn-ferroli btn-sm">
                                                <i class="fa fa-download"></i>
                                                <span>@lang('site::messages.load')</span>
                                            </button>
                                            <span class="invalid-feedback">{!! $errors->first('path') !!}</span>

                                            {{--<span id="pathHelp" class="d-block form-text text-success">--}}
                                            {{--@lang('site::order.help.load') <br/> @lang('site::order.help.xlsexample')--}}
                                            {{--</span>--}}
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="scheduler-border">
                                    <legend>@lang('site::storehouse_product.upload.url')</legend>
                                    <code class="d-block mb-3">{{ $storehouse->url }}</code>
                                    <form enctype="multipart/form-data"
                                          action="{{route('storehouses.url.store', $storehouse)}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-ferroli btn-sm">
                                            <i class="fa fa-download"></i>
                                            <span>@lang('site::messages.load')</span>
                                        </button>
                                        <input class="form-control {{  $errors->has('url') ? ' is-invalid' : '' }}" type="hidden" name="url" value="{{ $storehouse->url }}">
                                        <span class="invalid-feedback">{!! $errors->first('url') !!}</span>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </dd>
                </dl>
                {{--{{dump($errors)}}--}}
            </div>
        </div>
        @include('site::storehouse.products', compact('products', 'repository'))
    </div>
@endsection

@push('styles')
<style>
    fieldset.scheduler-border {
        border: 1px groove #eee !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #888;
        box-shadow: 0px 0px 0px 0px #888;
    }

    fieldset.scheduler-border legend {
        font-size: 1em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: inherit; /* Or auto */
        padding: 0 10px; /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>
@endpush
