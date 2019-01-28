<h2 class="my-5">@lang('site::event.events')</h2>
<div class="card-deck">
    @foreach($types as $type)
        <div class="card">
            <div class="card-body news-content">
                <h5 class="card-title">{{$type->name}}</h5>
                <p class="card-text">{!! $type->annotation !!}</p>
            </div>
            <div class="card-footer bg-lightest text-center">
                <a href="{{route('members.create', ['type_id' => $type->id])}}" class="btn btn-ferroli">@lang('site::messages.leave') @lang('site::member.member')</a>
            </div>
        </div>
    @endforeach
</div>