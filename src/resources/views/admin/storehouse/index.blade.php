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
            <li class="breadcrumb-item active">@lang('site::storehouse.storehouses')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::storehouse.icon')"></i> @lang('site::storehouse.storehouses')
        </h1>
        <div class=" border p-3 mb-2">
            <button form="repository-form"
                    type="submit"
                    name="excel"
                    class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 btn btn-primary">
                <i class="fa fa-upload"></i>
                <span>@lang('site::storehouse.header.download')</span>
            </button>
            <a class="@cannot('create', \QuadStudio\Service\Site\Models\Storehouse::class) disabled @endcannot btn btn-ferroli d-scheme d-sm-inline-block mr-0 mr-sm-1 mb-1"
               href="{{ route('admin.storehouses.create') }}"
               role="button">
                <i class="fa fa-magic"></i>
                <span>@lang('site::messages.create') @lang('site::storehouse.storehouse')</span>
            </a>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary mb-1">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @alert()@endalert()
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $storehouses])@endpagination
        {{$storehouses->render()}}
        @foreach($storehouses as $storehouse)
            <div class="card my-2" id="storehouse-{{$storehouse->id}}">

                <div class="card-header with-elements">

                    <div class="card-header-elements">
                        <a href="{{route('admin.storehouses.show', $storehouse)}}" class="mr-3 text-big">
                            {{$storehouse->name}}
                        </a>

                        {{--@component('site::components.bool.pill', ['bool' => $storehouse->enabled])@endcomponent--}}

                    </div>

                    <div class="card-header-elements ml-md-auto">

                        <a href="{{route('admin.users.show', $storehouse->user)}}">
                            @if($storehouse->user->image->fileExists)
                                <img id="user-logo" src="{{$storehouse->user->logo}}"
                                     style="width:25px!important;height: 25px"
                                     class="rounded-circle mr-2">
                            @endif
                            {{$storehouse->user->name}}
                        </a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xl-2 col-sm-6">

                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::storehouse.help.products')</dt>
                            @if($storehouse->uploaded_at)
                                <dd class="col-12">{{ $storehouse->products()->count() }}</dd>
                            @else
                                <dd class="col-12 text-danger">@lang('site::messages.no')</dd>
                            @endif
                        </dl>

                    </div>
                    <div class="col-xl-3 col-sm-6">

                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::storehouse.uploaded_at')</dt>
                            @if($storehouse->uploaded_at)
                                <dd class="col-12">{{$storehouse->uploaded_at->format('d.m.Y H:i')}}</dd>
                            @else
                                <dd class="col-12 text-danger">@lang('site::messages.never')</dd>
                            @endif
                        </dl>

                    </div>

                    <div class="col-xl-4 col-sm-6">
                        @if($storehouse->addresses()->exists())
                            <dl class="dl-horizontal mt-2">
                                {{--<dt class="col-12">@lang('site::storehouse.help.addresses')</dt>--}}
                                <dd class="col-12">
                                    <div class="list-group"></div>
                                    @foreach($storehouse->addresses as $address)
                                        <a href="{{route('admin.addresses.show', $address)}}"
                                           class="list-group-item list-group-item-action p-1">
                                            <i class="fa fa-@lang('site::address.icon')"></i> {{ $address->full }}
                                        </a>
                                    @endforeach
                                </dd>
                            </dl>
                        @endif
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-sm-2 mt-0">
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::storehouse.enabled')
                                <span>@bool(['bool' => $storehouse->enabled])@endbool</span>
                            </dt>
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                @lang('site::storehouse.everyday')
                                <span>@bool(['bool' => $storehouse->everyday])@endbool</span>
                            </dt>
                            @if($storehouse->url)
                            <dt class="col-12 mb-0 text-left text-xl-right">
                                <code>{{$storehouse->url}}</code>
                            </dt>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$storehouses->render()}}
    </div>
@endsection
