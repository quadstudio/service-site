<h2 class="my-5">@lang('site::event_type.h1')</h2>
<div class="card-deck">

<div class="card col-md-2" style="padding-left: 0px; padding-right: 0px;">
    <img style="width: 100%;" src="/images/skillabo-800.jpg" />
</div>
    @foreach($event_types as $event_type)
        <div class="card">
            <img class="card-img-top" src="{{$event_type->image->src()}}" alt="{{$event_type->name}}">
            <div class="card-body news-content">
                <h5 class="card-title">{{$event_type->name}}</h5>
                <p class="card-text">{!! $event_type->annotation !!}</p>
            </div>
            <div class="card-footer bg-lightest text-center">
                <a href="{{route('event_types.show', $event_type)}}" class="btn btn-ferroli">@lang('site::event_type.more')</a>
            </div>
        </div>
    @endforeach
</div>