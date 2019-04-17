<div class="col-sm-6 col-md-4 mb-5 news-item fixed-height-400">
    <a href="{{route('events.show', $event)}}">
        <figure>
            <img style="width: 100%;" src="{{Storage::disk($event->image->storage)->url($event->image->path)}}" alt="">
        </figure>
    </a>
    <div class="news-content">
        <div class="news-meta">

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
                <i class="fa mr-2 fa-@lang('site::event.icon')"></i>{{$event->type->name}}
            </span>
        </div>
        <h4 class="news-title my-4 text-ferroli"><a class="text-big" href="{{route('events.show', $event)}}">{{$event->title }}</a></h4>
        <div class="d-flex flex-column">
            <p class="news-annotation">
                {!! $event->annotation !!}
            </p>
        </div>
    </div>
</div>