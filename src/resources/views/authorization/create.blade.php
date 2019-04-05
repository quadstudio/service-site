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
                <a href="{{ route('authorizations.index') }}">@lang('site::authorization.authorizations')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.add')</li>
        </ol>
        <h1 class="header-title mb-4">@lang('site::messages.add') @lang('site::authorization.authorization')</h1>
        @alert()@endalert
        <div class="card mt-2 mb-2">
            <div class="card-body">
                @if(!$role->authorization_role->canCreate())
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">@lang('site::authorization.error.create.header')</h4>
                        <p>@lang('site::authorization.error.create.text', ['role' => $role->authorization_role->name])</p>
                        <hr>
                        <p class="mb-0">@lang('site::authorization.error.create.footer')</p>
                    </div>
                @endif
                <fieldset @if(!$role->authorization_role->canCreate()) disabled @endif>

                    <form id="authorization-form" method="POST" action="{{ route('authorizations.store') }}">
                        @csrf
                        <div class="form-group required">
                            <label class="control-label"
                                   for="role_id">@lang('site::authorization.role_id')</label>
                            <select class="form-control{{ $errors->has('authorization.role_id') ? ' is-invalid' : '' }}"
                                    required
                                    name="authorization[role_id]"
                                    id="role_id">
                                <option value="{{ $role->id }}">{{ $role->authorization_role->name }}</option>
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('authorization.role_id') }}</span>
                        </div>
                        <div class="form-group required mb-0">
                            <label class="control-label" title="">{{$role->authorization_role->title}}</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                   id="select-all"
                                   class="custom-control-input all-checkbox">
                            <label class="custom-control-label font-weight-bold"
                                   for="select-all">@lang('site::messages.select') @lang('site::messages.all')</label>
                        </div>
                        @foreach($authorization_types as $authorization_type)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       value="{{$authorization_type->id}}"
                                       @if($authorization_accepts->contains($authorization_type->id))
                                       disabled
                                       @endif
                                       @if(is_array(old('authorization_types')) && in_array($authorization_type->id, old('authorization_types')))
                                       checked
                                       @endif
                                       name="authorization_types[]"
                                       class="custom-control-input authorization-type-checkbox {{ $errors->has('authorization_types') ? ' is-invalid' : '' }}"
                                       id="{{$authorization_type->id}}">
                                <label class="custom-control-label
                                        @if($authorization_accepts->contains($authorization_type->id))
                                        text-lighter
                                        @endif"
                                       for="{{$authorization_type->id}}">
                                    {{$authorization_type->name}} {{$authorization_type->brand->name}}
                                    @if($authorization_accepts->contains($authorization_type->id))
                                        <span class="text-success">@lang('site::authorization.error.type_accept')</span>
                                    @endif
                                </label>
                                @if ($loop->last)
                                    <span class="invalid-feedback">{{ $errors->first('authorization_types') }}</span>
                                @endif
                            </div>
                        @endforeach
                        @include('site::authorization.create.address')
                    </form>
                </fieldset>


            </div>
        </div>
        <div class=" border p-3 mb-2">
            <button @if(!$role->authorization_role->canCreate()) disabled @endif form="authorization-form" type="submit"
                    class="btn btn-ferroli mb-1">
                <i class="fa fa-check"></i>
                <span>@lang('site::messages.save')</span>
            </button>
            <a href="{{ route('authorizations.index') }}" class="btn btn-secondary mb-1">
                <i class="fa fa-close"></i>
                <span>@lang('site::messages.cancel')</span>
            </a>

        </div>
    </div>
@endsection

@push('scripts')
<script>

    try {
        window.addEventListener('load', function () {

            let form = document.getElementById('authorization-form')
                , all = '.all-checkbox';

            if (form.addEventListener) {
                form.addEventListener("click", allClick);
            } else if (form.attachEvent) {
                form.attachEvent("onclick", allClick);
            }

            function allClick(event) {

                if (event.target.matches(all)) {
                    manageCheck(document.querySelectorAll('.authorization-type-checkbox'));
                }
            }

            function manageCheck(selectors) {
                for (i = 0; i < selectors.length; ++i) {
                    if(!selectors[i].disabled){
                        selectors[i].checked = event.target.checked;
                    }
                }
            }
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush