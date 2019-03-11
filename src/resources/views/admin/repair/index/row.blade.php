<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-7 col-md-3 col-xl-2">
                    <a href="{{ route('admin.repairs.show', $repair) }}"
                       class="text-large text-dark">№ {{$repair->id}}</a>
                    <div class="p-1" style="font-weight:normal;color: {{ $repair->status->color }}">
                        <i class="fa fa-{{ $repair->status->icon }}"></i> {{ $repair->status->name }}
                        @if($repair->fails()->count())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::fail.fails')"
                                  class="badge badge-danger text-big">{{$repair->fails()->count()}}</span>
                        @endif
                        @if($repair->messages()->count())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::message.messages')"
                                  class="badge badge-warning text-big">{{$repair->messages()->count()}}</span>
                        @endif
                    </div>
                    @if($repair->act)
                        <a href="{{route('admin.acts.show', $repair->act)}}"><i
                                    class="fa fa-@lang('site::act.icon')"></i> @lang('site::repair.act_id')
                            № {{ $repair->act->id }}</a> @lang('site::repair.received_'.($repair->act->received))
                    @endif
                </div>

                <div class="col-5 col-md-1 col-xl-2 text-right text-sm-right">
                  Создан  <b>{{$repair->created_at()}}</b> <br />
		  Ремонт  {{$repair->date_repair()}} <br />
                  Ввод  {{$repair->date_launch()}} <br />
                  Продажа  {{$repair->date_trade()}} <br />
                </div>
                <div class="col-12 col-md-3 col-xl-4">
                    <a href="{{route('admin.users.show', $repair->user)}}">{{ $repair->user->name }}</a>
                    <span class="text-muted">{{ $repair->user->address()->locality }}
			</span>
		   <br />{{ $repair->client }} {{ $repair->country->phone }}{{ $repair->phone_primary }} <br />{{ $repair->address }}
                </div>
                <div class="col-12 col-md-3 col-xl-2 text-right">
                    <div class="small mr-2 mr-sm-0">
                                {{$repair->product->name}} <br />
                                {{$repair->product->sku}} &nbsp;
                    		{{$repair->serial_id}}

				@if(count($parts = $repair->parts) > 0)
                                    @foreach($parts as $part)
                                            <br />{!! $part->product->sku !!} {!! $part->product->name !!}
                                    @endforeach
                                @else
                                    @lang('site::messages.not_found')
                                @endif


                    </div>
                </div>

		<div class="col-12 col-md-3 col-xl-2 text-right">
                    <div class="small mr-2 mr-sm-0"><b class="text-muted">@lang('site::repair.help.cost_difficulty')</b>&nbsp;{{$repair->cost_difficulty()}}
                        &nbsp;{{ Auth::user()->currency->symbol_right }}</div>
                    <div class="small mr-2 mr-sm-0"><b
                                class="text-muted">@lang('site::repair.help.cost_distance')</b>&nbsp;{{$repair->cost_distance()}}
                        &nbsp;{{ Auth::user()->currency->symbol_right }}<br><span class="text-muted"> {{ $repair->distance->name }}</span></div>
                    <div class="small"><b class="text-muted">@lang('site::repair.help.cost_parts')</b>&nbsp;{{Site::format($repair->cost_parts())}}
                    </div>
                    <div class="small"><b class="text-muted">@lang('site::repair.total_cost')</b>&nbsp;{{Site::format($repair->totalCost)}}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
