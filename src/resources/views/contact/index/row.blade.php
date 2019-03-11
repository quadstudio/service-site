<div class="items-col col-12" id="contact-{{$contact->id}}">

    <div class="card mb-4">
        <div class="card-body">

            <div class="items-dropdown btn-group">
                <button type="button"
                        class="btn btn-sm btn-ferroli border btn-round md-btn-flat dropdown-toggle icon-btn hide-arrow"
                        data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="items-dropdown-menu dropdown-menu dropdown-menu-right"
                     x-placement="bottom-end"
                     style="position: absolute; will-change: top, left; top: 26px; left: -134px;">
                    <a @can('edit', $contact)
                       href="{{route('contacts.edit', $contact)}}"
                       class="dropdown-item"
                       @else()
                       href="javascript:void(0);"
                       class="disabled dropdown-item"
                            @endcan>@lang('site::messages.edit')</a>
                    {{--<a class="disabled dropdown-item" href="javascript:void(0)">@lang('site::messages.edit')</a>--}}
                    <button @cannot('delete', $contact) disabled @endcannot
                    class="dropdown-item btn-row-delete"
                            data-form="#contact-delete-form-{{$contact->id}}"
                            data-btn-delete="@lang('site::messages.delete')"
                            data-btn-cancel="@lang('site::messages.cancel')"
                            data-label="@lang('site::messages.delete_confirm')"
                            data-message="@lang('site::messages.delete_sure') @lang('site::contact.contact')? "
                            data-toggle="modal" data-target="#form-modal"
                            href="javascript:void(0);" title="@lang('site::messages.delete')">
                        @lang('site::messages.delete')
                    </button>
                    <form id="contact-delete-form-{{$contact->id}}"
                          action="{{route('contacts.destroy', $contact)}}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <div class="item-content">

                <div class="item-content-about">
                    <div class="item-content-user text-muted small mb-2">{{$contact->type->name}}</div>
                    <h5 class="item-content-name mb-1">
                        {{$contact->name}} <span style="font-size: 12px"><a href="{{route('contacts.edit', $contact)}}">Изменить</a></span>
                    </h5>

                    @if($contact->position)
                        <div class="small">
                            {{$contact->position}}
                        </div>
                    @endif

                    @if(!$contact->phones->isEmpty())
                        <hr class="border-light">
                        <div>
                            @foreach($contact->phones as $phone)
                                <span class="text-secondary mr-3">{{$phone->country->phone}}{{$phone->number}}</span>
								@if($phone->extra) @lang('site::phone.extra') {{$phone->extra}} @endif
								<a href="{{route('phones.edit', $phone)}}">Изменить</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>