@if($news->isNotEmpty())
    <h2 class="mt-5">@lang('site::news.news')</h2>
    <div id="news-carousel" class="carousel mt-5 slide" data-ride="carousel">
        @if(($count = $news->count()) > 3)
            <ol class="carousel-indicators">
                <li data-target="#news-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#news-carousel" data-slide-to="1"></li>
            </ol>
        @endif
        <div class="carousel-inner">

            @foreach($news->chunk(3) as $items)
                <div class="carousel-item text-left  @if ($loop->first) active @endif">
                    <div class="row">
                        @foreach($items as $item)
                            @include('site::news.index.row', compact('item'))
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @if($count > 3)
            <a class="carousel-control-prev" href="#news-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon control-dark"
                              aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.prev')</span>
            </a>
            <a class="carousel-control-next" href="#news-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon control-dark" aria-hidden="true"></span>
                <span class="sr-only">@lang('site::messages.next')</span>
            </a>
        @endif
    </div>
    <div class="row mb-5">
        <div class="col text-center">
            <a class="btn btn-ferroli" href="{{route('news.index')}}">@lang('site::news.help.all')</a>
        </div>
    </div>
@endif