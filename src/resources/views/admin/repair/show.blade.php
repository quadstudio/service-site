@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.repairs.index') }}">@lang('site::repair.repairs')</a>
            </li>
            <li class="breadcrumb-item active">{{ $repair->id }}</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::repair.header.repair') № {{ $repair->id }}</h1>
        @alert()@endalert()
        <div class="border p-2 mb-2">
			<div class="d-sm-inline-block">
				<a href="{{ route('repairs.pdf', $repair) }}" 
					class="@cannot('pdf', $repair) disabled @endcannot d-block d-sm-inline-block mr-0 mr-sm-1 mb-1 mb-sm-0 btn btn-primary">
					<i class="fa fa-print"></i>
					<span>@lang('site::messages.print')</span>
				</a>
				<a href="{{ route('admin.users.force', $repair->user) }}"
				   class="d-block d-sm-inline-block btn mr-0 mr-sm-1 mb-1 mb-sm-0 btn-warning">
					<i class="fa fa-sign-in"></i>
					<span>@lang('site::user.force_login')</span>
				</a>
				<a href="{{ route('admin.repairs.index') }}" class="d-block d-sm-inline-block btn btn-secondary">
					<i class="fa fa-reply"></i>
					<span>@lang('site::messages.back')</span>
				</a>
			</div>
			<form id="called"  class="custom-control custom-checkbox d-sm-inline-block text-sm-right col-6 badge text-normal"
              method="POST"
              action="{{route('admin.repairs.update', $repair)}}">
			
			
            @csrf
            @method('PUT')
						
				<input name="repair[called_client]"
						   type="checkbox"
						   @if($repair->called_client)
						   checked
						   @endif
						   class="custom-control-input" id="called_client">
					<label class="custom-control-label" for="called_client">@lang('site::repair.called_1')</label>
				<button type="submit"
						form="called"
						class="d-block d-sm-inline-block btn btn-secondary">
					
					<span>Сохранить</span>
				</button>
			
			</form>	
			

        </div>
		
		@if($repair->duplicates_phones()->exists() || $repair->duplicates_serial()->exists() || $repair->date_trade->diffInDays($repair->date_call, false)>730 || $repair->date_launch->diffInDays($repair->date_call, false)>730)
            <div class="alert alert-danger" role="alert">
		
        @if($repair->duplicates_serial()->exists())
                <h4 class="alert-heading">@lang('site::messages.attention')</h4>
                <p>@lang('site::repair.help.duplicates_link', ['serial' => $repair->serial_id, 'link' => route('admin.repairs.index', ['filter[search_act]' => $repair->serial_id])])</p>
        @endif
        @if($repair->duplicates_phones()->exists())
                <h4 class="alert-heading">@lang('site::messages.attention')</h4>
                <p>@lang('site::repair.help.duplicates_phones_link', ['phone_primary' => $repair->phone_primary_raw, 'link' => route('admin.repairs.index', ['filter[search_client]' => $repair->phone_primary_raw])])</p>
        @endif
		
		@if($repair->date_trade->diffInDays($repair->date_call, false)>730 || $repair->date_launch->diffInDays($repair->date_call, false)>730)
		<p>С даты продажи <b />{{ $repair->date_trade->diffInDays($repair->date_call, false) }} дней</b></p>
		<p>С даты ввода в эксплуатацию <b />{{ $repair->date_launch->diffInDays($repair->date_call, false) }} дней</b></p>
		@endif
		
		</div>
		@endif
        @include('site::message.create', ['messagable' => $repair])

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Обратите внимание</h4>
            <p>
                Поля, отмеченные значком <i class="fa text-danger text-large fa-hand-pointer-o"></i>,
                можно пометить как <span class="bg-danger text-white px-1">заполненные с ошибокой</span>
            </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form id="form"
              method="POST"
              action="{{route('admin.repairs.update', $repair)}}">
            @csrf
            @method('PUT')
            <div class="card mb-2">
                <div class="card-body">

                    <h5 class="card-title">@lang('site::user.header.user')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::user.name')</dt>
                        <dd class="col-sm-8">
                            <a href="{{route('admin.users.show', $repair->user)}}">
                                {{ $repair->user->name }}
                            </a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.region_id')</dt>
                        <dd class="col-sm-8">{{ $repair->user->address()->region->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::address.locality')</dt>
                        <dd class="col-sm-8">{{ $repair->user->address()->locality }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.repair')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.created_at')</dt>
                        <dd class="col-sm-8">{{ $repair->created_at->format('d.m.Y H:i') }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.status_id')</dt>
                        <dd class="col-sm-8">
                        <span class="badge text-normal badge-{{$repair->status->color}}">
                            <i class="fa fa-{{$repair->status->icon}}"></i>
                            {{ $repair->status->name }}
                        </span>
                        </dd>
                    </dl>

                    <hr/>
                    <dl class="row">
                        <dt class="col-sm-4 text-left text-sm-right
                        @if($fails->contains('field', 'product_id')) bg-danger text-white @endif">
                            <label for="product_id" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.product_id')
                            </label>
                            <input id="product_id"
                                   value="product_id"
                                   @if($fails->contains('field', 'product_id')) checked @endif
                                   type="checkbox"
                                   name="fail[][field]"
                                   class="d-none repair-error-check"/>
                        </dt>
                        <dd class="col-sm-8">{{ $repair->product->name }}</dd>
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::product.sku')</dt>
                        <dd class="col-sm-8">{{ $repair->product->sku }}</dd>
                        <dt class="col-sm-4 text-left text-sm-right
                        @if($fails->contains('field', 'serial_id')) bg-danger text-white @endif">
                            <label for="serial_id" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.serial_id')
                            </label>
                            <input id="serial_id"
                                   value="serial_id"
                                   @if($fails->contains('field', 'serial_id')) checked @endif
                                   type="checkbox"
                                   name="fail[][field]"
                                   class="d-none repair-error-check"/>
                        </dt>
                        <dd class="col-sm-8">{{ $repair->serial_id }}</dd>
                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::serial.comment')</dt>
                        <dd class="col-sm-8">{{ $repair->serial ? $repair->serial->comment : null }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.payment')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right
                        @if($fails->contains('field', 'contragent_id')) bg-danger text-white @endif">
                            <label for="contragent_id"
                                   class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.contragent_id')
                            </label>
                            <input id="contragent_id"
                                   value="contragent_id"
                                   @if($fails->contains('field', 'contragent_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">
                            <a href="{{route('admin.contragents.show', $repair->contragent)}}">
                                {{ $repair->contragent->name }}
                            </a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right
                        @if($fails->contains('field', 'difficulty_id')) bg-danger text-white @endif">
                            <label for="difficulty_id" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.difficulty_id')
                            </label>
                            <input id="difficulty_id"
                                   value="difficulty_id"
                                   @if($fails->contains('field', 'difficulty_id')) checked @endif
                                   type="checkbox"
                                   name="fail[][field]"
                                   class="d-none repair-error-check"/>
                        </dt>
                        <dd class="col-sm-8">{{ $repair->difficulty->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right
                            @if($fails->contains('field', 'distance_id')) bg-danger text-white @endif">
                            <label for="distance_id"
                                   class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.distance_id')
                            </label>
                            <input id="distance_id"
                                   value="distance_id"
                                   @if($fails->contains('field', 'distance_id')) checked @endif
                                   type="checkbox"
                                   name="fail[][field]"
                                   class="d-none repair-error-check">

                        </dt>
                        <dd class="col-sm-8">{{ $repair->distance->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_distance')</dt>
                        <dd class="col-sm-8">{{ Site::format($repair->cost_distance())}}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_difficulty')</dt>
                        <dd class="col-sm-8">{{ Site::format($repair->cost_difficulty())}}</dd>

                        <dt class="col-sm-4 text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
                        <dd class="col-sm-8">{{ Site::format($repair->cost_parts())}}</dd>

                        <dt class="col-sm-4 text-left text-sm-right
                            @if($fails->contains('field', 'parts')) bg-danger text-white @endif">
                            <label for="parts" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::part.parts')
                            </label>
                            <input id="parts"
                                   value="parts"
                                   @if($fails->contains('field', 'parts')) checked @endif
                                   type="checkbox"
                                   name="fail[][field]"
                                   class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">
                            <fieldset id="admin-parts-fieldset">
                                @if(count($parts = $repair->parts) > 0)
                                    @foreach($parts as $part)
                                        <div class="row">
                                            <div class="col-4  text-info">
                                                <span id="part-{{$part->id}}">{{Site::format($part->total)}}</span>
                                                <a href="{{route('admin.parts.edit', $part)}}"
                                                   class="mr-3">@lang('site::messages.edit')</a>
                                            </div>
                                            <div class="col-8">{!! $part->product->sku !!} {!! $part->product->name !!}
                                                ({{Site::format($part->cost)}}
                                                x {{$part->count}} {{$part->product->unit}})
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    @lang('site::messages.not_found')
                                @endif
                            </fieldset>
                        </dd>
                        <dt class="col-sm-4 text-left text-sm-right border-top">Итого к оплате</dt>
                        <dd class="col-sm-8 border-sm-top border-top-0"
                            id="parts-total">{{ Site::format($repair->totalCost)}}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.client')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right
                            @if($fails->contains('field', 'client')) bg-danger text-white @endif">
                            <label for="client"
                                   class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.client')
                            </label>
                            <input id="client"
                                   value="client"
                                   @if($fails->contains('field', 'client')) checked @endif
                                   type="checkbox" name="fail[][field]"
                                   class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->client }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right
                            @if($fails->contains('field', 'country_id')) bg-danger text-white @endif">
                            <label for="country_id" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.country_id')
                            </label>
                            <input id="country_id"
                                   value="country_id"
                                   @if($fails->contains('field', 'country_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->country->name }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right
                        @if($fails->contains('field', 'address')) bg-danger text-white @endif">
                            <label for="address" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.address')
                            </label>
                            <input id="address"
                                   value="address"
                                   @if($fails->contains('field', 'address')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->address }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_primary')) bg-danger text-white @endif">
                            <label for="phone_primary"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.phone_primary')
                            </label>
                            <input id="phone_primary"
                                   value="phone_primary"
                                   @if($fails->contains('field', 'phone_primary')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->phone_primary }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'phone_secondary')) bg-danger text-white @endif">
                            <label for="phone_secondary"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.phone_secondary')
                            </label>
                            <input id="phone_secondary"
                                   value="phone_secondary"
                                   @if($fails->contains('field', 'phone_secondary')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->phone_secondary }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.org')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'trade_id')) bg-danger text-white @endif">
                            <label for="trade_id" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.trade_id')
                            </label>
                            <input id="trade_id"
                                   value="trade_id"
                                   @if($fails->contains('field', 'trade_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">
                            @if($repair->trade)
                                <a href="{{route('admin.trades.edit', $repair->trade)}}">
                                    {{ $repair->trade->name }}
                                </a>
                            @endif
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right
                                @if($fails->contains('field', 'date_trade')) bg-danger text-white @endif">
                            <label for="date_trade" class="pointer control-label">
                                <i class="fa text-danger fa-hand-pointer-o"></i>
                                @lang('site::repair.date_trade')
                            </label>
                            <input id="date_trade"
                                   value="date_trade"
                                   @if($fails->contains('field', 'date_trade')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_trade->format('d.m.Y') }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_launch')) bg-danger text-white @endif">
                            <label for="date_launch"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.date_launch')
                            </label>
                            <input id="date_launch"
                                   value="date_launch"
                                   @if($fails->contains('field', 'date_launch')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_launch->format('d.m.Y') }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.call')</h5>
                    <dl class="row">

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'engineer_id')) bg-danger text-white @endif">
                            <label for="engineer_id"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.engineer_id')
                            </label>
                            <input id="engineer_id"
                                   value="engineer_id"
                                   @if($fails->contains('field', 'engineer_id')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8"><a
                                    href="{{route('admin.engineers.edit', $repair->engineer)}}">{{ $repair->engineer->name }}</a>
                        </dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_call')) bg-danger text-white @endif">
                            <label for="date_call"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.date_call')
                            </label>
                            <input id="date_call"
                                   value="date_call"
                                   @if($fails->contains('field', 'date_call')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_call->format('d.m.Y') }}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'reason_call')) bg-danger text-white @endif">
                            <label for="reason_call"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.reason_call')
                            </label>
                            <input id="reason_call"
                                   value="reason_call"
                                   @if($fails->contains('field', 'reason_call')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->reason_call !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'diagnostics')) bg-danger text-white @endif">
                            <label for="diagnostics"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.diagnostics')
                            </label>
                            <input id="diagnostics"
                                   value="diagnostics"
                                   @if($fails->contains('field', 'diagnostics')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->diagnostics !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'works')) bg-danger text-white @endif">
                            <label for="works"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.works')
                            </label>
                            <input id="works"
                                   value="works"
                                   @if($fails->contains('field', 'works')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{!! $repair->works !!}</dd>

                        <dt class="col-sm-4 text-left text-sm-right @if($fails->contains('field', 'date_repair')) bg-danger text-white @endif">
                            <label for="date_repair"
                                   class="pointer control-label"><i
                                        class="fa text-danger fa-hand-pointer-o"></i> @lang('site::repair.date_repair')
                            </label>
                            <input id="date_repair"
                                   value="date_repair"
                                   @if($fails->contains('field', 'date_repair')) checked @endif
                                   type="checkbox" name="fail[][field]" class="d-none repair-error-check">
                        </dt>
                        <dd class="col-sm-8">{{ $repair->date_repair->format('d.m.Y') }}</dd>

                    </dl>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">@lang('site::repair.header.files')</h5>
                    @include('site::admin.file.files')
                </div>
            </div>
        </form>
        @if($statuses->isNotEmpty())
            <div class="card mb-4">
                <div class="card-body">
                    @foreach($statuses as $key => $status)
                        <button type="submit"
                                name="repair[status_id]"
                                value="{{$status->id}}"
                                form="form"
                                style="background-color: {{$status->color}};color:white"
                                class="pull-right mx-1 btn d-block d-sm-inline-block @if($key != $statuses->count()) mb-1 @endif">
                            <i class="fa fa-{{$status->icon}}"></i>
                            <span>{{$status->button}}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        try {
            window.addEventListener('load', function () {
                let i, checkbox, checks = document.querySelectorAll('.repair-error-check');
                for (i = 0; i < checks.length; i++) {
                    checks[i].addEventListener('click', function (e) {
                        checkbox = e.target;
                        if (checkbox.checked) {
                            checkbox.parentNode.classList.add('bg-danger');
                            checkbox.parentNode.classList.add('text-white');
                        } else {
                            checkbox.parentNode.classList.remove('bg-danger');
                            checkbox.parentNode.classList.remove('text-white');
                        }
                    })
                }
            });
        } catch (e) {
            console.log(e);
        }
    </script>
@endpush