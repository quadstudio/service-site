<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <a class="text-large mb-1"
                       href="{{ route('admin.engineers.show', $engineer) }}">{{ $engineer->name }}</a>
                </div>
                <div class="col-sm-4 text-left">
                    <a href="{{route('admin.users.show', $engineer->user)}}">{{ $engineer->user->name }}</a>
                </div>
                <div class="col-sm-4 text-right">
                    {{ $engineer->format() }}
                </div>
            </div>
        </div>
    </div>
</div>