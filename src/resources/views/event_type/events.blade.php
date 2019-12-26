<div class="card-deck">

<div class="card col-md-2" style="padding-left: 0px; padding-right: 0px;"><img style="width: 100%;" src="/images/skillabo-800.jpg" />
</div>
    @foreach($types as $type)
        <div class="card">
		<img class="card-img-top" src="{!! $type->image->src() !!}">
            <div class="card-body news-content">
			
                <h5 class="card-title">{{$type->name}}</h5>
                <p class="card-text">{!! $type->annotation !!}</p>
            </div>
            <div class="card-footer bg-lightest text-center">
                <a href="{!! $type->route !!}" class="btn btn-ferroli">@lang('site::event_type.more')</a>
            </div>
        </div>
    @endforeach
</div>
