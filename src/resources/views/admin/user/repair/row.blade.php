<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-4 col-xl-3">
                    <a href="{{ route('admin.repairs.show', $repair) }}" class="text-large text-dark">{{$repair->id}}</a>
                    <div class="p-1" style="font-weight:normal;color: {{ $repair->status->color }}"><i class="fa fa-{{ $repair->status->icon }}"></i> {{ $repair->status->name }} @if($repair->fails()->count()) <span class="badge badge-danger text-big">{{$repair->fails()->count()}}</span> @endif</div>
                </div>
                <div class="col-6 col-md-4 col-xl-3">
                    {{$repair->created_at->format('d.m.Y H:i')}}

                </div>
                <div class="col-12 col-md-4 col-xl-6">
                    <a href="{{route('admin.users.show', $repair->user)}}">{{ $repair->user->name }}</a>
                    <div class="text-muted">{{ $repair->user->address()->region->name }} / {{ $repair->user->address()->locality }}</div>
                </div>
            </div>

        </div>
    </div>
</div>