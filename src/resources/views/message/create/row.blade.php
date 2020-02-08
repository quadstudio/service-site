<div class="@if($message->user_id == auth()->user()->getAuthIdentifier()) chat-message-right @else chat-message-left @endif mb-4">
    <div>
        <img src="{{$message->user->logo}}"
             style="width: 40px!important;"
             class="rounded-circle" alt="">
        <div class="text-muted small text-nowrap mt-2">
            {{ $message->created_at->format('d.m.Y H:i') }}
        </div>
    </div>
    <div class="flex-shrink-1 rounded py-2 px-3
        @if($message->personal == 0) bg-lighter @else bg-dark @endif
        @if($message->user_id == auth()->user()->getAuthIdentifier()) mr-3 @else ml-3 @endif">
        <div class="mb-1"><b>{{$message->user->name}}</b></div>
        <span class="text-big">{!! nl2br($message->text) !!}</span>
    </div>
</div>