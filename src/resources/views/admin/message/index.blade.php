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
            <li class="breadcrumb-item active">@lang('site::message.messages')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::message.icon')"></i> @lang('site::message.messages')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <a href="{{ route('admin') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>

        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $messages])@endpagination

        <div class="card mb-4">
            <div class="card-body flex-grow-1 position-relative overflow-hidden">
                {{$messages->render()}}
                <div class="row no-gutters h-100">

                    <div class="d-flex col flex-column">
                        <div class="flex-grow-1 position-relative">

                            <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                            <div class="chat-messages p-4 ps">
                                @foreach($messages as $message)
                                    <div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">
                                        <div>
                                            <img src="{{$message->user->logo}}" style="width: 40px!important;"
                                                 class="rounded-circle" alt="">
                                            <div class="text-muted small text-nowrap mt-2">{{ $message->created_at->format('d.m.Y H:i') }}</div>
                                        </div>
                                        <div class="flex-shrink-1 bg-lighter rounded py-2 px-3 @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
                                            <div class="mb-2">
                                                <a class="text-dark"
                                                   href="{{route('admin.users.show', $message->user)}}">
                                                    <b>{{$message->user->name}}</b>
                                                </a>
                                            </div>
                                            <span class="text-big">{!! $message->text !!}</span>
                                            <hr/>
                                            <div class="">
                                                @if($message->user->admin == 1)
                                                    <a class="d-block text-muted"
                                                       href="{{route('admin.users.show', $message->receiver)}}">
                                                        @lang('site::message.receiver_id'): {{$message->receiver->name}}
                                                    </a>
                                                @endif
                                                @if(!is_null($messagable = $message->messagable))
                                                    <a class="d-block text-muted"
                                                       href="{{$messagable->messageRoute()}}">
                                                        @lang('site::message.help.messagable'): {{$messagable->messageSubject()}}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- / .chat-messages -->
                        </div>
                    </div>
                </div>
                {{$messages->render()}}
            </div>
        </div>

        {{--<div class="row items-row-view">--}}
        {{--@each('site::message.index.row', $messages, 'message')--}}
        {{--</div>--}}
    </div>
@endsection
