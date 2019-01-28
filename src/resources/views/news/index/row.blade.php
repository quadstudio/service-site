<div class="col-sm-6 col-md-4 mb-5 news-item fixed-height-450">
    <figure>
        <img style="width: 100%;" src="{{Storage::disk($item->image->storage)->url($item->image->path)}}" alt="">
    </figure>
    <div class="news-content">
        <div class="news-meta">
            {{--<a href="#" class="post-auth"><i class="fa fa-user"></i>Puffintheme</a>--}}
            <time datetime="{{$item->date}}">
                <i class="fa fa-@lang('site::news.icon')"></i> {{$item->date()}}
            </time>
        </div>
        <h4 class="news-title mb-3 text-ferroli">{{$item->title }}</h4>
        <div class="d-flex flex-column">
            <p class="news-annotation">
                {!! $item->annotation !!}
            </p>
            @if($item->hasDescription())
                <div class="news-description d-none">
                    {!! $item->description !!}
                </div>
                <a href="javascript:void(0);"
                   onclick="$(this).prev().toggleClass('d-none');$(this).parent().parent().parent().toggleClass('fixed-height-450')"
                   class="align-text-bottom text-right button button-ferroli">
                    Подробнее <i class="fa fa-chevron-down"></i>
                </a>
            @endif
        </div>
    </div>
</div>