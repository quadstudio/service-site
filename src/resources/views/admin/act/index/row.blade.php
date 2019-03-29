<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-2 col-xl-3">
                    <a href="{{ route('admin.acts.show', $act) }}" class="text-large text-dark">№ {{$act->id}}</a><br /> 1C:
			@foreach($act->schedules as $schedule)
			@lang('site::schedule.statuses.'.$schedule->status.'.text') <i class="fa fa-@lang('site::schedule.statuses.'.$schedule->status.'.icon') text-@lang('site::schedule.statuses.'.$schedule->status.'.color')"></i>
			@endforeach
                </div>
                <div class="col-6 col-md-2 col-xl-3 text-right text-sm-left">
                    {{$act->created_at->format('d.m.Y H:i' )}}<br />
			<span class="text-muted">@lang('site::act.received'):</span>&nbsp;
                            <span class="text-dark">@bool(['bool' => $act->received])@endbool</span>

                </div>
                <div class="col-12 col-md-5 col-xl-3">
                    <a href="{{route('admin.users.show', $act->user)}}">{{ $act->user->name }}</a>
                    <div class="text-muted">{{ $act->user->address()->region->name }} / {{ $act->user->address()->locality }}</div>
                </div>
                <div class="col-12 col-md-3 col-xl-3 text-right ">
                   @lang('site::act.help.total'): {{Site::format($act->total)}}
                </div>
            </div>

        </div>
    </div>
</div>
