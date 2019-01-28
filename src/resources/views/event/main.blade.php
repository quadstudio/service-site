@if($events->isNotEmpty())
    <div id="events-carousel" class="carousel mt-5 slide" data-ride="carousel">
        @if(($count = $events->count()) > 3)
            <ol class="carousel-indicators">
                <li data-target="#events-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#events-carousel" data-slide-to="1"></li>
            </ol>
        @endif
        <div class="carousel-inner">
            @foreach($events->chunk(3) as $items)
                <div class="carousel-item text-left  @if ($loop->first) active @endif">
                    <div class="row">
                        @foreach($items as $event)
                            @include('site::event.main.row', compact('event'))
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @if($count > 3)
            <a class="carousel-control-prev" href="#events-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon control-dark" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.prev')</span>
            </a>
            <a class="carousel-control-next" href="#events-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon control-dark" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.next')</span>
            </a>
        @endif
    </div>
    <div class="row mb-5">
        <div class="col text-center">
            <a class="btn btn-ferroli" href="{{route('events.index')}}">@lang('site::event.help.all')</a>
        </div>
    </div>
@endif