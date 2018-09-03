@extends('layouts.app')

@section('header')
    @include('site::header.front',[
        'h1' => 'Где купить?',
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => 'Где купить?']
        ]
    ])
@endsection
@section('content')
    <div class="container" id="app">

        @foreach($users as $user)
            <div class="card mb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="mb-0">{{$user->name}}</h4>
                        </div>
                        <div class="col-sm-4">
                            @php $address = $user->addresses()->where('type_id', 2)->first() @endphp
                            @if($address)
                                {{$address->region->name}} / {{$address->locality}}
                            @endif
                        </div>
                        <div class="col-sm-3">
                            @foreach($user->contacts()->where('type_id', 2)->with('phones')->get() as $contact)
                                @foreach($contact->phones as $phone)
                                    <span class="mr-2">{{$phone->country->phone}}{{$phone->number}}</span>
                                @endforeach
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
