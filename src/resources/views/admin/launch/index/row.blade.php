<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <a class="text-large mb-1"
                       href="{{ route('admin.launches.show', $launch) }}">{{ $launch->name }}</a>
                </div>
                <div class="col-sm-4 text-left">
                    <a href="{{route('admin.users.show', $launch->user)}}">{{ $launch->user->name }}</a>
                </div>
                <div class="col-sm-4 text-right">
                    {{ $launch->format() }}
                </div>
            </div>
        </div>
    </div>
</div>