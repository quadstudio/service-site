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
                <a href="{{ route('admin.'.$address->addressable->path().'.index') }}">@lang('site::'.$address->addressable->lang().'.'.$address->addressable->path())</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.'.$address->addressable->path().'.show', $address->addressable) }}">{{$address->addressable->name}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.'.$address->addressable->path().'.addresses.index', $address->addressable) }}">@lang('site::address.addresses')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.addresses.show', $address) }}">{{$address->full}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::address.regions')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::address.regions')</h1>

        @alert()@endalert()

        <div class="card mt-2 mb-2">
            <div class="card-body">
                <form id="district-form" method="POST"
                      {{--action="{{ route('admin.addresses.phones.store', $address) }}">--}}
                      action="{{ route('admin.addresses.regions.store', $address) }}">

                    @csrf

                    <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox"
                               id="selectAllRegions"
                               form="district-form"
                               class="custom-control-input all-checkbox">
                        <label class="custom-control-label font-weight-bold"
                               for="selectAllRegions">@lang('site::messages.select') @lang('site::messages.all')</label>
                    </div>

                    @foreach($districts as $district)

                        <div class="custom-control custom-checkbox mt-2">
                            <h4>
                                <input type="checkbox"
                                       id="{{$district->id}}"
                                       value="{{$district->id}}"
                                       {{--onclick="districtClick(this)"--}}
                                       class="custom-control-input district-checkbox">
                                <label class="custom-control-label"
                                       for="{{$district->id}}">{{$district->name}}</label>
                            </h4>
                        </div>

                        @foreach($district->regions()->orderBy('name')->get() as $region)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       value="{{$region->id}}"
                                       @if(is_array(old('regions')) && in_array($region->id, old('regions')) || is_null(old('regions')) && $address->regions->contains('id', $region->id))
                                       checked
                                       @endif
                                       name="regions[]"
                                       class="custom-control-input region-checkbox district-{{$district->id}}"
                                       id="{{$region->id}}">
                                <label class="custom-control-label"
                                       for="{{$region->id}}">{{$region->name}}</label>
                            </div>
                        @endforeach
                    @endforeach

                </form>
                <hr/>
                <div class=" mb-2 text-right">
                    <button form="district-form" type="submit"
                            class="btn btn-ferroli mb-1">
                        <i class="fa fa-check"></i>
                        <span>@lang('site::messages.save')</span>
                    </button>
                    <a href="{{ route('admin.addresses.show', $address) }}" class="btn btn-secondary mb-1">
                        <i class="fa fa-close"></i>
                        <span>@lang('site::messages.cancel')</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>

    try {
        window.addEventListener('load', function () {

            let form = document.getElementById('district-form')
                , district = '.district-checkbox'
                , all = '.all-checkbox';

            if (form.addEventListener) {
                form.addEventListener("click", districtClick);
            } else if (form.attachEvent) {
                form.attachEvent("onclick", districtClick);
            }

            function districtClick(event) {

                if (event.target.matches(district)) {

                    manageCheck(document.querySelectorAll('.district-' + event.target.value));

                } else if (event.target.matches(all)) {
                    manageCheck(document.querySelectorAll('.region-checkbox'));
                    manageCheck(document.querySelectorAll('.district-checkbox'));
                }
            }

            function manageCheck(selectors) {
                for (i = 0; i < selectors.length; ++i) {
                    selectors[i].checked = event.target.checked;
                }
            }
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush