@if(!$user->active)
    <del>
        @endif
        <a class="text-big" href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
        @if(!$user->active)
    </del>
@endif