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
            <a class="@cannot('edit', $storehouse) disabled @endcannot btn btn-ferroli d-block d-sm-inline-block mr-0 mr-sm-1 mb-1"
               href="{{ route('storehouses.edit', $storehouse) }}"
               role="button">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>

            <button @cannot('delete', $storehouse) disabled @endcannot
            class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 btn btn-danger btn-row-delete"
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
            @if($storehouse->logs()->exists())
                <a href="{{ route('storehouses.logs.index', $storehouse) }}"
                   class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 btn btn-secondary">
                    <i class="fa fa-@lang('site::storehouse_log.icon')"></i>
                    <span>@lang('site::storehouse_log.storehouse_logs')</span>
                    <span class="badge badge-light">{{$storehouse->logs()->count()}}</span>
                </a>
            @endif
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
        @if($storehouse->hasLatestLogErrors())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::storehouse_log.storehouse_logs')</h4>
                <p>@lang('site::storehouse.error.upload.message', [
                            'date' => $storehouse->latestLog()->created_at->format('d.m.Y'),
                            'link' => '<a class="alert-link" href="'.route('storehouses.show', $storehouse).'">'.$storehouse->name.'</a>',
                        ])</p>

                <ul>
                    @foreach($storehouse->latestLog()->message as $message)
                        <li>&bull;&nbsp;{{$message}}</li>
                    @endforeach
                </ul>
                <hr>
                <a href="{{ route('storehouses.logs.index', $storehouse) }}"
                   class="btn btn-sm btn-danger">@lang('site::storehouse_log.button')</a>
            </div>
        @endif
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
										<br><b>@lang('site::address.regions'): {{$address->regions->count()}}</b>
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
                                <fieldset class="scheduler-border" @if(!$storehouse->url) disabled @endif>
                                    <legend>@lang('site::storehouse_product.upload.url')</legend>
                                    <code class="d-block mb-3">{{ $storehouse->url ?: trans('site::storehouse.help.url_not_defined') }}</code>
                                    <form id="storehouse-url-form"
                                          enctype="multipart/form-data"
                                          method="post"
                                          action="{{route('storehouses.url.store', $storehouse)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-ferroli btn-sm">
                                            <i class="fa fa-download"></i>
                                            <span>@lang('site::messages.load')</span>
                                        </button>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </dd>
                </dl>
                <div class="row">
                    <div class="col">
                        <input form="storehouse-url-form"
                               class="form-control {{  $errors->has('url') ? ' is-invalid' : '' }}" type="hidden"
                               name="url" value="{{ $storehouse->url }}">
                        <span id="storehouse-product-form" class="invalid-feedback">{!! $errors->first('url') !!}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control {{  $errors->has('check') ? ' is-invalid' : '' }}" type="hidden"
                               name="check" value="">
                        <span class="invalid-feedback">{!! $errors->first('check') !!}</span>
                    </div>
                </div>
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

@push('scripts')
    <script>

        try {
            window.addEventListener('load', function () {

                let span = document.getElementById('storehouse-product-form')
                    , all = '#check-all';

                if (span.addEventListener) {
                    span.addEventListener("click", districtClick);
                } else if (span.attachEvent) {
                    span.attachEvent("onclick", districtClick);
                }

                function districtClick(event) {

                    if (event.target.matches(all)) {
                        manageCheck(document.querySelectorAll('.storehouse-product-check:not(.disabled)'));
                    }
                }

                function manageCheck(selectors) {
                    for (i = 0; i < selectors.length; ++i) {
                        selectors[i].checked = event.target.checked;
                    }
                }
            });
        } catch (e) {
            console.log(e);
        }

    </script>
@endpush
