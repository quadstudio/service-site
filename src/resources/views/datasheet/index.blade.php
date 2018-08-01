@extends('layouts.app')
@section('header')
    @include('site::header.front',[
        'h1' => __('site::datasheet.datasheets'),
        'breadcrumbs' => [
            ['url' => route('index'), 'name' => __('site::messages.index')],
            ['name' => __('site::datasheet.datasheets')]
        ]
    ])
@endsection
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                {{$datasheets->render()}}
                @filter(['repository' => $repository])@endfilter
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">@lang('site::datasheet.type_id')</th>
                        {{--<th scope="col">@lang('site::equipment.equipments')</th>--}}
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @each('site::datasheet.index.row', $datasheets, 'datasheet')
                    </tbody>
                </table>
                {{$datasheets->render()}}
            </div>
        </div>

    </div>
@endsection
