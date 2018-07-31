@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::organization.organizations')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::organization.icon')"></i> @lang('site::organization.organizations')</h1>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">@lang('site::organization.name')</th>
                        <th scope="col" class="d-none d-sm-table-cell text-center">@lang('site::organization.id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::admin.organization.index.row', $organizations, 'organization')
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
