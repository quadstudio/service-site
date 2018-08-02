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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::order.orders')</li>
        </ol>
        <h1 class="header-titlemb-4"><i
                    class="fa fa-@lang('site::order.icon')"></i> @lang('site::order.orders') {{$user->name}}</h1>
        @alert()@endalert()


        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        {{$orders->render()}}
                    </div>
                </div>

                @filter(['repository' => $repository, 'route_param' => $user])@endfilter
                <table class="table table-striped table-bordered" role="grid">
                    <thead>
                    <tr role="row">
                        <th rowspan="1" colspan="1" class="text-center"><span
                                    class="d-none d-md-block">@lang('site::order.status_id')</span></th>
                        <th rowspan="1" colspan="1" class="text-center">@lang('site::order.created_at')</th>
                        <th rowspan="1" colspan="1" class="text-right">@lang('site::order.total')</th>
                        <th rowspan="1" colspan="1"
                            class="d-none d-md-table-cell">@lang('site::order.comment')</th>
                        <th rowspan="1" colspan="1">@lang('site::order.id')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="text-center" style="color:{{$order->status->color}}">
                                <i class="fa fa-{{$order->status->icon}}"></i>
                                <span class="d-none d-md-block"> {{$order->status->name}}</span>
                            </td>
                            <td class="text-center">{{$order->created_at(true)}}</td>
                            <td class="text-right">{{Site::format($order->total())}}</td>
                            <td class="d-none d-md-table-cell">{!! $order->comment!!}</td>
                            <td><a href="{{route('admin.orders.show', $order)}}">{{$order->id}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12">
                        {{$orders->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection