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
            <li class="breadcrumb-item active">@lang('site::message.messages')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-4">
            <a class="disabled btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"
               href="{{ route('messages.create') }}"
               role="button">
                <i class="fa fa-edit"></i>
                <span>@lang('site::messages.write') @lang('site::message.message')</span>
            </a>
            <a href="{{ route('home') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_home')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        <div class="chat-wrapper container-p-x container-p-y">
            <div class="card flex-grow-1 position-relative overflow-hidden">
                <div class="row no-gutters h-100">
                    <div class="chat-sidebox col">
                        <div class="flex-grow-0 px-4">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <input type="text" class="form-control chat-search my-3" placeholder="Поиск...">
                                </div>
                                <a href="javascript:void(0)"
                                   class="chat-sidebox-toggler d-lg-none d-block text-muted text-large font-weight-light pl-3">×</a>
                            </div>
                            <hr class="border-light m-0">
                        </div>
                        <div class="flex-grow-1 position-relative">
                            <div class="chat-contacts list-group chat-scroll py-3 ps">

                                <!-- Online -->
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action online">
                                    <img src="/products/appwork/v110/assets_/img/avatars/2-small.png"
                                         class="d-block ui-w-40 rounded-circle" alt="">
                                    <div class="media-body ml-3">
                                        Администратор
                                        <div class="chat-status small">
                                            <span class="badge badge-dot"></span>&nbsp; Online
                                        </div>
                                    </div>
                                    <div class="badge badge-outline-success">3</div>
                                </a>
                            </div>
                            <!-- / .chat-contacts -->
                        </div>
                    </div>
                    <div class="d-flex col flex-column">
                        <div class="flex-grow-0 py-3 pr-4 pl-lg-4">

                            <div class="media align-items-center">
                                <a href="javascript:void(0)"
                                   class="chat-sidebox-toggler d-lg-none d-block text-muted text-large px-4 mr-2">
                                    <i class="ion ion-md-more"></i>
                                </a>

                                <div class="position-relative">
                                    <span class="badge badge-dot badge-success indicator"></span>
                                    <img src="/products/appwork/v110/assets_/img/avatars/4-small.png"
                                         class="ui-w-40 rounded-circle" alt="">
                                </div>
                                <div class="media-body pl-3">
                                    <strong>Отчет по ремонту № ML125394</strong>
                                    <div class="text-muted small">
                                        <em>Люфицеров Игнат Иванович +79253045567</em>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-round icon-btn mr-1">
                                        <i class="ion ion-ios-call"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-round icon-btn mr-1">
                                        <i class="ion ion-md-videocam"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-round icon-btn">
                                        <i class="ion ion-ios-more"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <hr class="flex-grow-0 border-light m-0">
                        <div class="flex-grow-1 position-relative">

                            <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                            <div class="chat-messages chat-scroll p-4 ps">
                                @foreach($messages as $message)
                                    <div class="@if($message->user_id == Auth::user()->id) chat-message-right @else chat-message-left @endif mb-4">
                                        <div>
                                            <img src="{{$message->user->logo}}" style="width: 40px!important;"
                                                 class="rounded-circle" alt="">
                                            <div class="text-muted small text-nowrap mt-2">{{ $message->created_at(true) }}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 mr-3">
                                            <div class="mb-1"><b>{{$message->user->name}}</b></div>
                                            {!! $message->text !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- / .chat-messages -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="row items-row-view">--}}
        {{--@each('site::message.index.row', $messages, 'message')--}}
        {{--</div>--}}
    </div>
@endsection
