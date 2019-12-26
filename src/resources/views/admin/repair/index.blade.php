@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::repair.repairs')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-@lang('site::repair.icon')"></i> @lang('site::repair.repairs')
        </h1>

        @alert()@endalert()

        <div class=" border p-3 mb-2">
            <button form="repository-form"
                    type="submit"
                    name="excel"
                    class="d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
                <i class="fa fa-upload"></i>
                <span>@lang('site::messages.upload') @lang('site::messages.to_excel')</span>
            </button>
            <a href="{{ route('admin') }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back_admin')</span>
            </a>
        </div>
        @filter(['repository' => $repository])@endfilter
        @pagination(['pagination' => $repairs])@endpagination
        {{$repairs->render()}}
        @foreach($repairs as $repair)
            <div class="card my-4" id="repair-{{$repair->id}}">

                <div class="card-header py-1 with-elements">
                    <div class="card-header-elements">
                        <a href="{{route('admin.repairs.show', $repair)}}" class="mr-2">
                            @lang('site::repair.header.repair') № {{$repair->id}}
                        </a>
                        <span class="badge text-normal badge-pill text-white"
                              style="background-color: {{ $repair->status->color }}">
                            <i class="fa fa-{{ $repair->status->icon }}"></i> {{ $repair->status->name }}
                        </span>
						<span class="badge text-normal badge-pill text-white"
                              style="background-color: @lang('site::repair.called_color_'.($repair->called_client))">@lang('site::repair.called_'.($repair->called_client))
							  </span>
                    </div>

                    <div class="card-header-elements ml-md-auto">
                        <a href="{{route('admin.users.show', $repair->user)}}" class="mr-3 ml-0">
                            <img id="user-logo"
                                 src="{{$repair->user->logo}}"
                                 style="width:25px!important;height: 25px"
                                 class="rounded-circle mr-2">{{$repair->user->name}}
                        </a>
                        @if($repair->fails()->count())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::fail.fails')"
                                  class="badge badge-danger text-normal badge-pill">
                                <i class="fa fa-exclamation-triangle"></i> {{ $repair->fails()->count() }}
                            </span>
                        @endif
                        @if($repair->act)
                            <a href="{{route('admin.acts.show', $repair->act)}}">
                                <span data-toggle="tooltip"
                                      data-placement="top"
                                      title="@lang('site::repair.act_id'). @lang('site::repair.received_'.($repair->act->received))"
                                      class="badge @if($repair->act->received) badge-success @else badge-warning @endif text-normal badge-pill">
                                <i class="fa fa-@lang('site::act.icon')"></i>

                                </span>
                            </a>
                        @endif
                        @if( $repair->messages()->exists())
                            <span data-toggle="tooltip" data-placement="top" title="@lang('site::message.messages')"
                                  class="badge badge-secondary text-normal badge-pill">
                                <i class="fa fa-comment"></i> {{ $repair->messages()->count() }}
                            </span>
                        @endif
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.created_at')</dt>
                            <dd class="col-12">{{$repair->created_at->format('d.m.Y')}}</dd>
                            <dt class="col-12">@lang('site::repair.date_repair')</dt>
                            <dd class="col-12">{{$repair->date_repair->format('d.m.Y')}}</dd>
                            <dt class="col-12">@lang('site::repair.date_launch')</dt>
                            <dd class="col-12">
							@if($repair->date_launch->diffInDays($repair->date_call, false)>730)
							<span class="bg-danger text-white px-2">{{$repair->date_launch->format('d.m.Y')}}</span>
							@else
							{{$repair->date_launch->format('d.m.Y')}}
							@endif
							</dd>
                            <dt class="col-12">@lang('site::repair.date_trade')</dt>
                            <dd class="col-12">
							@if($repair->date_trade->diffInDays($repair->date_call, false)>730)
							<span class="bg-danger text-white px-2">{{$repair->date_trade->format('d.m.Y')}}</span>
							@else
							{{$repair->date_trade->format('d.m.Y')}}
							@endif
							</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.product_id')</dt>
                            <dd class="col-12">{{$repair->product->name}}</dd>
                            <dt class="col-12">@lang('site::product.sku')</dt>
                            <dd class="col-12">{{$repair->product->sku}}</dd>
                            <dt class="col-12">@lang('site::repair.serial_id')</dt>
                            <dd class="col-12">
                                @if($repair->serial_id)
                                    <div class="bg-light p-2">
									@if($repair->duplicates_serial->isNotEmpty())
										{{$repair->serial_id}} 
									<a href="{{route('admin.repairs.index', ['filter[search_act]' => $repair->serial_id])}}"><span data-toggle="tooltip" data-placement="top" title="@lang('site::repair.help.duplicates')" class="badge text-normal badge-pill badge-danger">
									<i class="fa fa-copy"></i> {{$repair->duplicates_serial->count()}}
									</span></a>
									<br /><span class="bg-danger text-white px-2">@lang('site::repair.error.serial_dup')</span>
									@else
									{{$repair->serial_id}} 
									@endif
									</div>
                                    @if($repair->serial()->exists())
                                        <div class="text-muted">{{$repair->serial->product->name}}</div>
                                        <div class="text-muted">{{$repair->serial->comment}}</div>
                                    @else
                                        <span class="bg-danger text-white px-2">@lang('site::serial.error.not_found')</span>
                                    @endif
									
                                @else
                                    <span class="bg-danger text-white px-2">@lang('site::serial.error.not_exist')</span>
                                @endif
								
                            </dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.client')</dt>
                            <dd class="col-12">{{$repair->client}}</dd>
                            <dt class="col-12">@lang('site::repair.address')</dt>
                            <dd class="col-12">{{$repair->address}}</dd>
                            <dt class="col-12">@lang('site::repair.phone_primary')</dt>
                            <dd class="col-12">
							@if($repair->duplicates_phones->isNotEmpty())
										{{$repair->phone_primary}} 
									<a href="{{route('admin.repairs.index', ['filter[search_client]' => $repair->phone_primary_raw])}}"><span data-toggle="tooltip" data-placement="top" title="@lang('site::repair.help.duplicates')" class="badge text-normal badge-pill badge-danger">
									<i class="fa fa-copy"></i> {{$repair->duplicates_phones->count()}}
									</span></a>
									<br /><span class="bg-danger text-white px-2">@lang('site::repair.error.phones_dup')</span>
									@else
									{{$repair->phone_primary}} 
									@endif	
								
								
							</dd>
                        </dl>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <dl class="dl-horizontal mt-2">
                            <dt class="col-12">@lang('site::repair.cost_difficulty')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_difficulty(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::repair.cost_distance')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_distance(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::repair.cost_parts')</dt>
                            <dd class="col-12">
                                {{number_format($repair->cost_parts(), 0, '.', ' ')}}
                                {{ $repair->user->currency->symbol_right }}
                            </dd>
                            <dt class="col-12">@lang('site::part.parts')</dt>
                            <dd class="col-12">
                                @if(count($parts = $repair->parts) > 0)
                                    <ul class="list-group"></ul>
                                    @foreach($parts as $part)
                                        <li class="list-group-item p-1">{!! $part->product->sku !!} {!! $part->product->name !!}</li>
                                    @endforeach
                                @else
                                    @lang('site::messages.not_found')
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        @endforeach
        {{$repairs->render()}}
    </div>
@endsection
