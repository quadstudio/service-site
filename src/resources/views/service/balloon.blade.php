<div class="card mb-2">
    <div class="card-body">
        <h4 class="card-title">{{$sc}}</h4>
        <div class="row">
            <div class="col">
                @if($asc)
                    <span class="badge text-normal badge-success">@lang('site::service.header.asc')</span>
                @endif
                @if($dealer)
                    <span class="badge text-normal badge-success">@lang('site::service.header.dealer')</span>
                @endif
            </div>
        </div>
        <dl class="row">

            <dt class="col-sm-4">@lang('site::register.sc_address')</dt>
            <dd class="col-sm-8">{{$address->name}}</dd>

            <dt class="col-sm-4">@lang('site::phone.phones')</dt>
            <dd class="col-sm-8">
                @foreach($phones as $phone)
                    <span>{{$phone->country->phone}}{{$phone->number}}</span>
                    @if(!is_null($phone->extra))<span> (@lang('site::phone.extra'): {{$phone->extra}})</span> @endif
                @endforeach
            </dd>

            <dt class="col-sm-4">@lang('site::user.email')</dt>
            <dd class="col-sm-8"><a href="mailto:{{$email}}">{{$email}}</a></dd>

            @if(!is_null($web))
                <dt class="col-sm-4">@lang('site::contact.web')</dt>
                <dd class="col-sm-8"><a target="_blank" href="{{$web}}" class="card-link">{{$web}}</a></dd>
            @endif

        </dl>

    </div>
    {{--<img style="width: 25px;" class="img-fluid border" src="{{ asset($address->country->flag) }}" alt="">--}}
</div>