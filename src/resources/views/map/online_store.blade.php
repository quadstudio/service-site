@extends('layouts.app')
@section('title')@lang('site::map.online_store.title')@lang('site::messages.title_separator')@endsection


@section('header')
    @include('site::header.front',[
        'h1' => '<i class="fa fa-'.__('site::map.online_store.icon').'"></i> '
        .__('site::map.online_store.title'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::map.online_store.title')]
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
                    @include('site::map.balloon', [
                        'name' => $address->name,
                        'address' => $address->address,
                        'roles' => $user_roles,
                        'phones' => $address->phones,
                        'email' => $address->email,
                        'web' => $address->web,
			            'logo' => $address->addressable->logo,
			            'accepts' => $address->addressable->authorization_accepts()->where('role_id', 3)->whereHas('type', function($query){
                            $query->where('brand_id', 1);
                        })->get(),
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection
