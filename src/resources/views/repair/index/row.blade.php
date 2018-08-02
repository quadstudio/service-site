<div class="repair-list-row row border-bottom no-gutters">
    <div class="col-md-4 col-xl-2 p-2 pr-md-0">

        <a href="{{route('repairs.show', $repair)}}">{{$repair->number}}</a>
        <div class="px-1" style="color: {{$repair->status->color}};">
            <i class="fa fa-{{$repair->status->icon}} mr-1"></i>
            <span class="small">{{$repair->status->name}}</span>
        </div>
    </div>
    <div class="col-md-4 col-xl-2 py-md-2 px-2 pb-2">
        <div class="small"><b class="text-muted">@lang('site::repair.created_at')
                :</b>&nbsp;{{$repair->created_at()}}</div>
        <div class="small"><b class="text-muted">@lang('site::repair.date_repair')
                :</b>&nbsp;{{$repair->date_repair()}}</div>
    </div>
    <div class="col-md-4 col-xl-2 py-md-2 px-2 pb-2">
        <div class="small"><b class="text-muted">
                @lang('site::serial.product_id'):</b>&nbsp;{{$repair->serial->product->name}}
        </div>
        <div class="small"><b class="text-muted">
                @lang('site::repair.serial_id'):</b>&nbsp;{{$repair->serial_id}}
        </div>
    </div>
    <div class="col-md-8 col-xl-5 py-md-2 px-2 pb-2">
        <div class="small"><b class="text-muted">@lang('site::repair.client'):</b>&nbsp;{{$repair->client}}</div>
        <div class="small"><b class="text-muted">@lang('site::repair.address'):</b>&nbsp;{{$repair->address}}</div>
    </div>

    <div class="d-flex col-md-4 col-xl-1 flex-md-column flex-wrap justify-content-md-center align-items-start px-2 px-md-0 pt-md-2 pb-2">
        <div class="small mr-2 mr-sm-0"><b class="text-muted">@lang('site::repair.help.cost_work')</b>&nbsp;{{$repair->cost_work()}}
            &nbsp;{{ Auth::user()->currency->symbol_right }}</div>
        <div class="small mr-2 mr-sm-0"><b class="text-muted">@lang('site::repair.help.cost_road')</b>&nbsp;{{$repair->cost_road()}}
            &nbsp;{{ Auth::user()->currency->symbol_right }}</div>
        <div class="small"><b class="text-muted">@lang('site::repair.help.cost_parts')</b>&nbsp;{{Site::format($repair->cost_parts())}}</div>
    </div>
</div>
{{--<table class="table table-hover table-sm">--}}
{{--<thead>--}}
{{--<tr>--}}
{{--<th rowspan="2" scope="col">@lang('site::repair.created_at')</th>--}}
{{--<th rowspan="2" scope="col">@lang('site::repair.number')</th>--}}
{{--<th rowspan="2" scope="col">@lang('site::serial.product_id')</th>--}}
{{--<th class="text-center" colspan="3">Оплата, {{ Auth::user()->currency->symbol_right }}</th>--}}
{{--<th class="text-center" rowspan="2" scope="col">@lang('site::repair.status_id')</th>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<th class="text-right">@lang('site::repair.help.cost_work')</th>--}}
{{--<th class="text-right">@lang('site::repair.help.cost_road')</th>--}}
{{--<th class="text-right">@lang('site::repair.help.cost_parts')</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}

{{--</tbody>--}}
{{--</table>--}}
{{--<tr>--}}
{{--<td>{{$repair->created_at()}}</td>--}}
{{--<td><a href="{{route('repairs.show', $repair)}}">{{$repair->number}}</a></td>--}}
{{--<td>{{$repair->serial->product->name}}</td>--}}
{{--<td class="text-right">{{$repair->cost_work()}}</td>--}}
{{--<td class="text-right">{{ $repair->cost_road()}}</td>--}}
{{--<td class="text-right">{{$repair->cost_parts()}}</td>--}}
{{--<td class="text-center">{{$repair->status->name}}</td>--}}
{{--</tr>--}}