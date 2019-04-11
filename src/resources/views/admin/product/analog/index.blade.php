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
                <a href="{{ route('admin.products.index') }}">@lang('site::product.cards')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.show', $product) }}">{{$product->fullName}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::analog.analogs')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::analog.analogs')</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{ route('admin.products.show', $product) }}" class="d-block d-sm-inline-block btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::product.help.back')</span>
            </a>
        </div>

        <div class="card mb-4 ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" id="form-content"
                              action="{{ route('admin.products.analogs.store', $product) }}">

                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       @if(old('mirror', 1) == 1)
                                                       checked
                                                       @endif
                                                       id="mirror"
                                                       value="1"
                                                       name="mirror">
                                                <label class="custom-control-label" for="mirror">
                                                    @lang('site::messages.mirror')
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <button form="form-content" type="submit" class="btn btn-ferroli">
                                        <i class="fa fa-download"></i>
                                        <span>@lang('site::messages.load')</span>
                                    </button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-row required">
                                        <div class="col mb-3">
                                            <label class="control-label d-block"
                                                   for="separator_row">@lang('site::messages.separator.row')</label>
                                            @foreach(trans('site::messages.symbol') as $key => $value)
                                                <div class="custom-control d-block custom-radio custom-control-inline">
                                                    <input class="custom-control-input
                                                         {{$errors->has('separator_row') ? ' is-invalid' : ''}}"
                                                           type="radio"
                                                           name="separator_row"
                                                           required
                                                           @if(old('separator_row', '\r\n') == $key) checked @endif
                                                           id="separator_row_{{$key}}"
                                                           value="{{$key}}">
                                                    <label class="custom-control-label"
                                                           for="separator_row_{{$key}}">{!! $value !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="analogs">@lang('site::analog.analogs')</label>
                                            <textarea
                                                    class="form-control{{ $errors->has('analogs') ? ' is-invalid' : '' }}"
                                                    placeholder="@lang('site::analog.placeholder')"
                                                    name="analogs"
                                                    rows="5"
                                                    id="analogs">{{ old('analogs') }}</textarea>
                                            <span class="invalid-feedback">{{ $errors->first('analogs') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-6">
                        @if($analogs->isNotEmpty())
                            <form method="POST" id="form-delete"
                                  action="{{ route('admin.products.analogs.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           @if(old('mirror_delete', 1) == 1)
                                                           checked
                                                           @endif
                                                           form="form-delete"
                                                           id="mirror_delete"
                                                           value="1"
                                                           name="mirror">
                                                    <label class="custom-control-label" for="mirror_delete">
                                                        @lang('site::messages.mirror')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-right">
                                        <button form="form-delete" type="submit"
                                                class="btn btn-danger mr-0 mr-sm-1 mb-1 mb-sm-0">
                                            <i class="fa fa-close"></i>
                                            <span>@lang('site::messages.delete')</span>
                                        </button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="custom-control custom-checkbox mb-4">
                                    <input type="checkbox"
                                           id="all"
                                           class="custom-control-input all-checkbox">
                                    <label class="custom-control-label font-weight-bold"
                                           for="all">@lang('site::messages.select') @lang('site::messages.all')</label>
                                </div>
                                @foreach($analogs as $analog)
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                       class="custom-control-input analog-checkbox{{$errors->has('delete') ? ' is-invalid' : ''}}"
                                                       id="analog-{{$analog->id}}"
                                                       value="{{$analog->id}}"
                                                       name="delete[]">
                                                <label class="custom-control-label" for="analog-{{$analog->id}}">
                                                    {{$analog->fullName}}
                                                </label>
                                                @if ($loop->last)
                                                    <span class="invalid-feedback">{{ $errors->first('delete') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection


@push('scripts')
<script>

    try {
        window.addEventListener('load', function () {

            let form = document.getElementById('form-delete')
                , all = '.all-checkbox';
            if (form !== null) {
                if (form.addEventListener) {
                    form.addEventListener("click", checkboxClick);
                } else if (form.attachEvent) {
                    form.attachEvent("onclick", checkboxClick);
                }
            }


            function checkboxClick(event) {

                if (event.target.matches(all)) {
                    manageCheck(document.querySelectorAll('.analog-checkbox'));
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