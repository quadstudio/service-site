<div class="items-col col-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="item-content">
                <div class="item-content-about">
                    <h5 class="item-content-name mb-1">
                        <a href="{{ route('messages.show', $message) }}" class="text-dark">{{$message->name}}</a>
                    </h5>
                    <div class="item-content-user text-muted mb-2">@lang('site::engineer.address')
                        : {{$message->address}}</div>
                    <div class="item-content-user text-muted small mb-2">
                        <img style="width: 30px;" class="img-fluid border" src="{{ asset($message->country->flag) }}"
                             alt="">
                        {{ $message->country->name }}
                    </div>
                    <hr class="border-light">
                    <div>
                        <span class="text-secondary mr-3">{{$message->country->phone}}{{$message->phone}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>