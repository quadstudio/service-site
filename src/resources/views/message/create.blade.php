<div class="card my-2">
    <div class="card-body flex-grow-1 position-relative overflow-hidden">
        <h5 class="card-title">@lang('site::message.messages')</h5>
        <div class="row no-gutters">
            <div class="d-flex col flex-column">
                <div class="flex-grow-1 position-relative">
                    <div id="messages" class="chat-messages p-2 ps">
                        @if($messagable->publicMessages->isNotEmpty())
                            @each('site::message.create.row', $messagable->publicMessages, 'message')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <form id="form-content" action="{{$messagable->messageStoreRoute()}}" method="post">
            @csrf
            <div class="row no-gutters">
                <div class="d-flex col flex-column">
                    <div class="flex-grow-1 position-relative">
                        <div class="form-group required">
                            <input type="hidden"
                                   name="message[receiver_id]"
                                   value="{{$messagable->messageReceiver()->getAttribute('id')}}">
                            <textarea required
                                      name="message[text]"
                                      id="message_text"
                                      rows="3"
                                      placeholder="@lang('site::message.placeholder.text_to') {{$messagable->messageReceiver()->getAttribute('name')}}"
                                      class="form-control{{  $errors->has('message.text') ? ' is-invalid' : '' }}"></textarea>
                            <span class="invalid-feedback">{{ $errors->first('message.text') }}</span>
                        </div>
                        @admin
                        <div class="form-group">
                            <select required
                                    class="form-control"
                                    name="message[personal]"
                                    title="@lang('site::message.personal')">
                                <option value="1" @if(old('message.personal') === 1) selected @endif>@lang('site::message.help.personal_1')</option>
                                <option value="0" @if(old('message.personal') === 0) selected @endif>@lang('site::message.help.personal_0')</option>
                            </select>
                            <span class="invalid-feedback">{{ $errors->first('message.personal') }}</span>
                        </div>
                        @endadmin
                        <button type="submit"
                                class="btn btn-success d-block d-sm-inline-block add-message-button">
                            <i class="fa fa-check"></i>
                            <span>@lang('site::messages.send')</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
