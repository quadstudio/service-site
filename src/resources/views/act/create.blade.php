@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">@lang('site::messages.home')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('acts.index') }}">@lang('site::act.acts')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.create')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.create') @lang('site::act.act')</h1>

        @alert()@endalert()
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('site::messages.has_error')</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> @lang('site::mounting.info.title')</h4>
            <p>@lang('site::mounting.info.text', ['cost' => config('site.mounting_min_cost', 3000)])</p>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form id="form"
                      method="POST"
                      enctype="multipart/form-data"
                      action="{{ route('acts.store') }}">
                    @csrf
                    @foreach($mountings_group as $contragent_id => $mountings)
                        <div class="row">
                            <div class="col">
                                <h5>{{$contragents[$contragent_id]->name}}</h5>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-9 col-sm-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           id="contragent-{{$contragent_id}}"
                                           value="{{$contragent_id}}"
                                           class="contragent-checkbox custom-control-input">
                                    <label class="custom-control-label font-weight-bold"
                                           for="contragent-{{$contragent_id}}">@lang('site::messages.select') @lang('site::messages.all')</label>
                                </div>
                            </div>
                            <div class="col-sm-3 d-none d-sm-inline-block text-center font-weight-bold">
                                @lang('site::mounting.created_at')
                            </div>
                            <div class="col-sm-3 d-none d-sm-inline-block text-center font-weight-bold">
                                @lang('site::mounting.client')
                            </div>
                            <div class="col-sm-3 d-none d-sm-inline-block text-right font-weight-bold">
                                @lang('site::mounting.bonus')
                            </div>
                        </div>
                        @foreach($mountings as $mounting)
                            <div class="form-row required @if($mountings->count() > 1 && !$loop->last) border-bottom @endif">
                                <div class="col-9 col-sm-3">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                                type="checkbox"
                                                value="{{$mounting->id}}"
                                                @if(is_array(old('mountings.'.$contragent_id)) && in_array($mounting->id, old('mountings.'.$contragent_id)))
                                                checked
                                                @endif
                                                data-cost="{{$mounting->total}}"
                                                data-contragent="{{$contragent_id}}"
                                                name="mountings[{{$contragent_id}}][]"
                                                class="custom-control-input mounting-checkbox
                                                contragent-{{$contragent_id}}
                                                {{ $errors->has('mountings.'.$contragent_id) ? ' is-invalid' : '' }}"
                                                id="mounting-{{$mounting->id}}">
                                        <label class="custom-control-label" for="mounting-{{$mounting->id}}">
                                            № {{$mounting->id}}
                                            <span class="d-inline-block d-sm-none">
                                            / {{$mounting->created_at->format('d.m.Y')}} / {{$mounting->client}}
                                            </span>
                                        </label>
                                        @if ($loop->last)
                                            <span class="invalid-feedback">
                                                {{ $errors->first('mountings.'.$contragent_id) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-3 d-none d-sm-inline-block pt-1 text-center">
                                <span data-toggle="tooltip" data-placement="top"
                                      title="@lang('site::mounting.created_at')">
                                    {{$mounting->created_at->format('d.m.Y')}}
                                </span>
                                </div>
                                <div class="col-sm-3 d-none d-sm-inline-block pt-1 text-center">
                                <span data-toggle="tooltip" data-placement="top"
                                      title="@lang('site::mounting.client')">
                                    {{$mounting->client}}
                                </span>
                                </div>
                                <div class="col-sm-3 pt-1 text-right">
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="@lang('site::mounting.bonus')">
                                        {{number_format($mounting->bonus, 0, '.', ' ')}}
                                        {{ $mounting->user->currency->symbol_right }}
                                    </span> +
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="@lang('site::mounting.social_bonus')">
                                            {{number_format($mounting->enabled_social_bonus, 0, '.', ' ')}}
                                        {{ $mounting->user->currency->symbol_right }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                        <div class="row border-top">
                            <div class="col text-right font-weight-bold text-large pt-2">
                                @lang('site::messages.total'):
                                <span id="total-{{$contragent_id}}">0</span> {{ $contragents[$contragent_id]->user->currency->symbol_right }}
                            </div>
                        </div>
                    @endforeach
                    <hr/>
                    <div class="form-row">
                        <div class="col text-right">
                            <button form="form" type="submit"
                                    class="btn btn-ferroli mb-1">
                                <i class="fa fa-check"></i>
                                <span>@lang('site::messages.create')</span>
                            </button>
                            <a href="{{ route('acts.index') }}" class="btn btn-secondary mb-1">
                                <i class="fa fa-close"></i>
                                <span>@lang('site::messages.cancel')</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    try {
        window.addEventListener('load', function () {
            let form = document.getElementById('form')
                , contragent = '.contragent-checkbox'
                , mountings = document.getElementsByClassName('mounting-checkbox');

            if (form !== null) {
                if (form.addEventListener) {
                    form.addEventListener("click", selectAllClick);
                } else if (form.attachEvent) {
                    form.attachEvent("onclick", selectAllClick);
                }
            }

            for (i = 0; i < mountings.length; ++i) {
                if (mountings[i].addEventListener) {
                    mountings[i].addEventListener("click", setTotal);
                } else if (mountings[i].attachEvent) {
                    mountings[i].attachEvent("onclick", setTotal);
                }
            }

            function selectAllClick(event) {

                if (event.target.matches(contragent)) {
                    let selectors = document.querySelectorAll('.contragent-' + event.target.value);
                    for (i = 0; i < selectors.length; ++i) {
                        selectors[i].checked = event.target.checked;
                    }
                    setTotal();
                }
            }

            function setTotal() {

                let total = {};
                let selectors = document.querySelectorAll('.mounting-checkbox');
                for (i = 0; i < selectors.length; ++i) {
                    let id = selectors[i].getAttribute('data-contragent')
                        , name = '_' + id;
                    if (!total.hasOwnProperty(name)) {
                        total[name] = 0;
                    }
                    if (selectors[i].checked === true) {
                        total[name] += parseInt(selectors[i].getAttribute('data-cost'));
                    }
                    document.getElementById('total-' + id).textContent = total[name];
                }
            }

            setTotal();
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush
