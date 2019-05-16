@extends('layouts.app')

@section('title')@lang('site::member.members')@lang('site::messages.title_separator')@endsection
@section('header')
    @include('site::header.front',[
        'h1' => __('site::member.members'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::member.members')]
        ]
    ])
@endsection
@section('content')
    <div class="container mb-5">
        @alert()@endalert
        {{--<div class="justify-content-start border p-3 mb-2">--}}
        {{--<a class="btn btn-ferroli d-page d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0"--}}
        {{--href="{{ route('members.create') }}"--}}
        {{--role="button">--}}
        {{--<i class="fa fa-plus"></i>--}}
        {{--<span>@lang('site::messages.leave') @lang('site::member.member')</span>--}}
        {{--</a>--}}
        {{--</div>--}}
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $members])@endpagination
        {{$members->render()}}
        @foreach($members as $member)
            <div class="card my-2" id="member-{{$member->id}}">

                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::member.place')</dt>
                            <dd class="col-12">{{$member->region->name}}, {{$member->city}}</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::member.type_id')</dt>
                            <dd class="col-12">
                                <a href="{{route('event_types.show', $member->type)}}">
                                    {{$member->type->name}}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::member.date')</dt>
                            <dd class="col-12">
                                {{$member->date_from->format('d.m.Y')}}
                                @if($member->date_from->ne($member->date_to))
                                    -&nbsp;{{$member->date_to->format('d.m.Y')}}
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-0 mt-sm-2">
                            <dt class="col-12">@lang('site::member.name')</dt>
                            <dd class="col-12">{{$member->name}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$members->render()}}
    </div>
@endsection