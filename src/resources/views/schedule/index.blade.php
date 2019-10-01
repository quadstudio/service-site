<ul class="list-group list-group-flush">
    @if($schedules->count())
        @foreach($schedules as $schedule)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    {{$schedule->status == 0 ? $schedule->created_at->format('d.m.Y H:i') : $schedule->updated_at->format('d.m.Y H:i')}}
                </div>
                <div @if($schedule->status == 2)
                     data-toggle="tooltip" data-placement="top" title="{!!$schedule->message!!}"
                        @endif>
                    @include('site::schedule.status')
                </div>
            </li>
        @endforeach
    @else
        <li class="list-group-item d-flex justify-content-between align-items-center">@lang('site::messages.not_found')</li>
    @endif
</ul>