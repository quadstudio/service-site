<div class="card mb-2">
    <div class="card-body">
        <h4 class="card-title">{{$name}}</h4>

        <dl class="row">

            <dd class="col-12">{{$address}}</dd>
            <dd class="col-12">
                @if($asc)
                    <span class="badge text-normal badge-success">@lang('site::service.header.asc')</span>
                @endif
                @if($dealer)
                    <span class="badge text-normal badge-success">@lang('site::service.header.dealer')</span>
                @endif
            </dd>

            <dt class="col-sm-4">@lang('site::phone.phones')</dt>
            <dd class="col-sm-8">
                @foreach($phones as $phone)
                    <div>{{$phone->format()}}</div>
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