<div class="col-md-12">
<div class="card mb-1">
<div class="card-body">
    <div class="row">
        <div class="col-md-3 news-meta-top">

            <time datetime="{{$event->date_from->format('d.m.Y')}}">
                <i class="fa mr-2 fa-@lang('site::news.icon')"></i>{{$event->date_from->format('d.m.Y')}}
                @if($event->date_from->format('d.m.Y') != $event->date_to->format('d.m.Y'))
                    - {{$event->date_to->format('d.m.Y')}}
                @endif
            </time>
            <span class="d-block mt-2 news-type">
                <i class="fa mr-2 fa-map-marker"></i>{{ $event->region->name }}, {{ $event->city }}
            </span>
			<span class="d-block mt-2 news-type">
				<i class="fa mr-2 fa-status-{{ $event->status->id }}"></i>{{ $event->status->name }}
            </span>

        </div>
		
		<div class="col-md-3">
        <a class="text-big" href="{{route('events.show', $event)}}">{{$event->title }}</a>
		</div>
        <div class="col-md-4">
            <p class="news-annotation">
                {!! $event->annotation !!}
            </p>
        </div><div class="col-md-2 ">
			<a class="btn btn-ferroli" href="{{route('members.create', ['event_id' => $event->id])}}">@lang('site::event.register')</a>
		</div>
    </div>
</div></div></div>