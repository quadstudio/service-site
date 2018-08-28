<div class="items-col col-12" data-id="{{$difficulty->id}}">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-8 col-sm-6">
                    <a class="text-large mb-1"
                       href="{{ route('admin.difficulties.edit', $difficulty) }}">{{ $difficulty->name }}</a>
                </div>
                <div class="col-4 col-sm-6 text-xlarge text-right">
                    {{ Site::format($difficulty->cost) }}
                </div>
            </div>
        </div>
    </div>
</div>