@if($announcements->isNotEmpty())
    <h2 class="mt-5">@lang('site::announcement.announcements')</h2>
    <div id="announcement-carousel" class="carousel mt-5 slide">
        @if(($count = $announcements->count()) > 3)
            <ol class="carousel-indicators">
                <li data-target="#announcement-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#announcement-carousel" data-slide-to="1"></li>
            </ol>
        @endif
        <div class="carousel-inner">

            @foreach($announcements->chunk(3) as $items)
                <div class="carousel-item text-left  @if ($loop->first) active @endif">
                    <div class="row">
                        @foreach($items as $announcement)
                            @include('site::announcement.index.row', compact('announcement'))
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @if($count > 3)
            <a class="carousel-control-prev" href="#announcement-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon control-dark"
                              aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.prev')</span>
            </a>
            <a class="carousel-control-next" href="#announcement-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon control-dark" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.next')</span>
            </a>
        @endif
    </div>
    <div class="row mb-5">
        <div class="col text-center">
            <a class="btn btn-ferroli" href="{{route('announcements.index')}}">@lang('site::announcement.help.all')</a>
        </div>
    </div>
@endif
