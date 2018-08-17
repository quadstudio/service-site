<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-4 col-xl-3">
                    <a href="{{ route('admin.acts.show', $act) }}" class="text-large text-dark">№ {{$act->id}}</a>
                </div>
                <div class="col-6 col-md-4 col-xl-3">
                    {{$act->created_at()}}
                </div>
                <div class="col-12 col-md-4 col-xl-6">
                    <a href="{{route('admin.users.show', $act->user)}}">{{ $act->user->name }}</a>
                    <div class="text-muted">{{ $act->user->address()->region->name }} / {{ $act->user->address()->locality }}</div>
                </div>
            </div>

        </div>
    </div>
</div>