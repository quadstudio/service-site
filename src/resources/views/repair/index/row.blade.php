<div class="items-col col-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="item-content">
                <div class="item-content-about">
                    <h5 class="item-content-name mb-1">
                        <a href="{{ route('repairs.show', $repair) }}" class="text-big">№ {{$repair->id}}</a>
                        <span class="p-1" style="font-weight:normal;color: {{ $repair->status->color }}">
                            <i class="fa fa-{{ $repair->status->icon }}"></i> {{ $repair->status->name }}
                            @if($repair->fails()->count())
                                <span class="badge badge-danger">{{$repair->fails()->count()}}</span>
                            @endif
                        </span>
                        @if($repair->act)
                            <a href="{{route('acts.show', $repair->act)}}"><i
                                        class="fa fa-@lang('site::act.icon')"></i> @lang('site::repair.act_id')
                                № {{ $repair->act->id }}</a>
                        @endif
                    </h5>
                    <div class="repair-list-row row no-gutters">
                        <div class="col-md-6 col-xl-2 py-md-2 px-2 pb-2">
                            <div class="small"><b class="text-muted">@lang('site::repair.created_at')
                                    :</b>&nbsp;{{$repair->created_at->format('d.m.Y H:i')}}</div>
                            <div class="small"><b class="text-muted">@lang('site::repair.date_repair')
                                    :</b>&nbsp;{{$repair->date_repair()}}</div>
                        </div>
                        <div class="col-md-6 col-xl-2 py-md-2 px-2 pb-2">
                            <div class="small"><b class="text-muted">
                                    @lang('site::serial.product_id'):</b>&nbsp;{{$repair->product->name}}
                            </div>
                            <div class="small"><b class="text-muted">
                                    @lang('site::repair.serial_id'):</b>&nbsp;{{$repair->serial_id}}
                            </div>
                        </div>
                        <div class="col-md-8 col-xl-6 py-md-2 px-2 pb-2">
                            <div class="small"><b class="text-muted">@lang('site::repair.client')
                                    :</b>&nbsp;{{$repair->client}}</div>
                            <div class="small"><b class="text-muted">@lang('site::repair.address')
                                    :</b>&nbsp;{{$repair->address}}</div>
                        </div>

                        <div class="d-flex col-md-4 col-xl-2 flex-md-column flex-wrap justify-content-md-center align-items-start px-2 px-md-0 pt-md-2 pb-2">
                            <div class="small mr-2 mr-sm-0"><b
                                        class="text-muted">@lang('site::repair.help.cost_difficulty')</b>&nbsp;{{$repair->cost_difficulty()}}
                                &nbsp;{{ Auth::user()->currency->symbol_right }}</div>
                            <div class="small mr-2 mr-sm-0"><b
                                        class="text-muted">@lang('site::repair.help.cost_distance')</b>&nbsp;{{$repair->cost_distance()}}
                                &nbsp;{{ Auth::user()->currency->symbol_right }}</div>
                            <div class="small"><b
                                        class="text-muted">@lang('site::repair.help.cost_parts')</b>&nbsp;{{Site::format($repair->cost_parts())}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>