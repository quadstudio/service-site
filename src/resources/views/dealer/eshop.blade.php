@extends('layouts.app')
@section('title')@lang('site::address.eshops')@lang('site::messages.title_separator')@endsection


@section('header')
    @include('site::header.front',[
        'h1' => '<i class="fa fa-'.__('site::dealer.icon').'"></i> '.__('site::address.eshops'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::address.eshops')]
        ]
    ])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($addresses as $address)
                    @php $user_roles = [] @endphp
                    @foreach ($roles as $role)
                        @if($address->addressable->hasRole($role->name))
                            @php $user_roles[] = $role->title @endphp
                        @endif
                    @endforeach
                    @include('site::dealer.balloon', [
                        'name' => $address->name,
                        'address' => $address->address,
                        'roles' => $user_roles,
                        'phones' => $address->phones,
                        'email' => $address->email,
                        'web' => $address->web,
			'logo' => $address->addressable->logo,
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection
