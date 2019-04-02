<div class="card mb-2">
    <div class="card-body">
	<div class="media">
	<img id="user-logo" src="{{$logo}}" style="width:100px!important;height: 100px" >
	<div class="media-body ml-3">
        <h4 class="card-title">{{$name}}</h4>

        <dl class="row">

            <dd class="col-12">{{$address}}</dd>
<!---            <dd class="col-12">
                @foreach($roles as $role)
                    <span class="badge text-normal mb-0 mb-sm-1 badge-primary">{{$role}}</span>
                @endforeach
            </dd>
-->
            <dt class="col-sm-4">@lang('site::phone.phones')</dt>
            <dd class="col-sm-8">
                @foreach($phones as $phone)
                    <div>{{$phone->country->phone}} {{$phone->number}}</div>
                @endforeach
            </dd>

            <dt class="col-sm-4">@lang('site::user.email')</dt>
            <dd class="col-sm-8"><a href="mailto:{{$email}}">{{$email}}</a></dd>

            @if(!is_null($web))
                <dt class="col-sm-4">@lang('site::contact.web')</dt>
                <dd class="col-sm-8"><a target="_blank" href="{{$web}}" class="card-link">{{$web}}</a></dd>
            @endif

        </dl>
</div></div>
    </div>

</div>
