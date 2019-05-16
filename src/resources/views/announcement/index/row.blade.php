<div class="col-sm-6 col-md-4 mb-5 announcement-item fixed-height-450">

    <div class="announcement-content">
        <div class="announcement-meta">
            {{--<a href="#" class="post-auth"><i class="fa fa-user"></i>Puffintheme</a>--}}
            <time datetime="{{$announcement->date}}">
                <i class="fa fa-@lang('site::announcement.icon')"></i> {{$announcement->date->format('d.m.Y')}}
            </time>
        </div>
    @if($announcement->image)
    <figure class="mt-3">
        <img style="width: 100%;" src="{{Storage::disk($announcement->image->storage)->url($announcement->image->path)}}" alt="">
    </figure>
    @endif
        <h4 class="announcement-title mb-3 text-ferroli">{{$announcement->title }}</h4>
        <div class="d-flex flex-column">
            <p class="announcement-annotation">
                {!! $announcement->annotation !!}
            </p>
            @if($announcement->hasDescription())
                <div class="announcement-description d-none">
                    {!! $announcement->description !!}
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
