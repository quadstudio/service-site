@if(!$user->active)
    <del>
        @endif
        <a class="text-xlarge" href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
        {{--<span title="ID" class="text-muted">[ #{{ $user->id }} ]</span>--}}
        @if(!$user->active)
    </del>
@endif