{{--<tr>--}}
{{--<td></td>--}}
{{--<td><a href="{{route('admin.currencies.show', $currency)}}">{{ $currency->name }}</a></td>--}}
{{--<td class="d-none d-sm-table-cell">{{ $currency->title }}</td>--}}
{{--<td class="text-right">{{ $currency->rates }}</td>--}}
{{--<td class="d-none d-sm-table-cell text-center">{{ $currency->id }}</td>--}}
{{--</tr>--}}
<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-3">
                    <a class="text-big" href="{{route('admin.currencies.show', $currency)}}">{{ $currency->name }}</a>
                </div>
                <div class="col-12 col-md-3">
                    {{ $currency->title }}
                </div>
                <div class="col-12 col-md-3">
                    {{ $currency->rates }}
                </div>
                <div class="col-12 col-md-3">
                    @if($currency->updated_at)
                        {{ \Carbon\Carbon::instance($currency->updated_at)->format('d.m.Y H:i') }}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
