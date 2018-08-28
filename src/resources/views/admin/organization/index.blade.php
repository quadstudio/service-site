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
            <li class="breadcrumb-item active">@lang('site::organization.organizations')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::organization.icon')"></i> @lang('site::organization.organizations')</h1>
        {{$organizations->render()}}
        @pagination(['pagination' => $organizations])@endpagination
        @filter(['repository' => $repository])@endfilter
        <div class="row">
            @each('site::admin.organization.index.row', $organizations, 'organization')
        </div>
        {{$organizations->render()}}
    </div>
@endsection
