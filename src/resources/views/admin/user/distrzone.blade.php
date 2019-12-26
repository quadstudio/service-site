@extends('layouts.app')



@push('scripts')
<script>
    let checkColumn = function(targetClassElements, checked) {
        let elements = document.getElementsByClassName(targetClassElements);
        for (i = 0; i < elements.length; i++) {
            elements[i].checked = checked;
        }
    };
</script>
@endpush

@section('content')
    <div class="container" id="app">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">@lang('site::user.users')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.show', $user) }}">{{$user->name}}</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::user_distrzone.user_distrzone')</li>
        </ol>
        <h1 class="header-title mb-4"><i
                    class="fa fa-@lang('site::user_price.icon')"></i> @lang('site::user_distrzone.user_distrzone') {{$user->name}}
        </h1>

        @alert()@endalert()

        <div class="card mb-4">
            <div class="card-body">
                <form id="form-content" method="POST" action="{{ route('admin.users.distrzones.store', $user) }}">
                    @csrf
                     <table class="table bg-white table-hover">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input type="checkbox"
                                       id="mark_all"
                                       checked
                                       class="form-check-input"/>
                                <label for="mark_all" class="form-check-label">@lang('site::messages.mark') @lang('site::messages.all') / @lang('site::messages.unmark')</label>
                            </div>
                        </th>
                        
                        
                    </tr>
                    </thead>
                    <tbody>
					@foreach($districts as $district)
					    
						<tr>
                            <td>
                               <b>{{$district->district_name}}</b>
                            </td>
                            
                        </tr>
						
						@foreach($regions->where('district_id', $district->id) as $region)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="region[]"
                                           value="{{$region->id}}"
                                           
                                           checked
                                           form="form-content"
                                           
                                           class="form-check-input" id="{{$region->id}}">
                                    <label class="form-check-label"
                                           for="region-{{$region->id}}">{{$region->name}}</label>
                                </div>
                            </td>
                            
                        </tr>
						@endforeach
					@endforeach
                    
                    </tbody>
                </table>
                </form>
                <hr/>
                <div class="form-row">
                    <div class="col text-right">
                        <button name="_stay" form="form-content" value="1" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save_stay')</span>
                        </button>
                        <button name="_stay" form="form-content" value="0" type="submit" class="btn btn-ferroli">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.save')</span>
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary mb-1">
                            <i class="fa fa-close"></i>
                            <span>@lang('site::messages.cancel')</span>
                        </a>
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
            $(document).ready(function () {
                checkEmails = function () {
                    let emails = [];
                    $('input[name="recipient[]"]:checked').each(function (i, e) {
                        emails.push($(e).val());
                    });
                    $('#emails').html(emails.join(', '));
                };

                checkEmails();

                $('body')
                    .on('click', 'input[name="recipient[]"]', function (e) {
                        checkEmails();
                    })
                    .on('change', '#mark_all', function () {
                        $("input:checkbox").prop('checked', $(this).prop("checked"));
                    })
                    .on('click', '.attachment-add', function () {

                        let list = $('#attachments-list'),
                            action = $(this).data('action');

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: action,
                            type: 'GET',
                            dataType: 'html',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                list.append(response);
                            },
                        });
                    })
                    .on('change', '#template_id', function (e) {
                        let select = $(this), option = select.find('option:selected');

                        if (option.val() !== '') {

                            $.ajax({
                                type: 'GET',
                                dataType: 'json',
                                url: option.data('action'),
                                data: [],
                                success: function (template) {
                                    if (template !== false && template !== null) {
                                        $('#title').val(template.title);
                                        $('#content').summernote('code', template.content);
                                    }
                                }
                            });
                        }
                    })
            });
        });
    } catch (e) {
        console.log(e);
    }

</script>
@endpush
