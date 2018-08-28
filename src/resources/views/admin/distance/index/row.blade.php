<div class="items-col col-12" data-id="{{$distance->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-8 col-sm-6">
                    <a class="text-large mb-1"
                       href="{{ route('admin.distances.edit', $distance) }}">{{ $distance->name }}</a>
                </div>
                <div class="col-4 col-sm-6 text-xlarge text-right">
                    {{ Site::format($distance->cost) }}
                </div>
            </div>
        </div>
    </div>
</div>