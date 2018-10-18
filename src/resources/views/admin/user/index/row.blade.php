<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-5">
                    @include('site::admin.user.component.link')
                    @include('site::admin.user.component.online')
                    @if(($addresses = $user->addresses()->where('type_id', 2)->get())->isNotEmpty())
                        <div class="my-2 mb-md-0">
                            @foreach($addresses as $address)
                                <span class="d-block">{{ $address->region->name }} &bull; {{ $address->locality }}
                            </span>
                            @endforeach
                        </div>
                    @endif
                    <div>
                        @foreach($roles as $role)
                            @if($user->hasRole($role->name))
                                <span class="d-block text-normal  text-success ">✔ {{$role->title}}</span>
                            @endif
                        @endforeach
                    </div>

                </div>
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="mb-2 mb-md-0 text-muted">
                        <span class="d-block">@lang('site::user.created_at'):
                            {{$user->created_at(true)}}
                        </span>
                        <span class="d-block" class="text-muted">@lang('site::user.logged_at'):
                            {{ $user->logged_at() }}
                        </span>
                        <span class="d-block" class="text-muted">@lang('site::order.help.last'):
                            @if($order = $user->orders()->latest()->first())
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y H:i')}}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="mb-2 mb-md-0 text-secondary text-left text-md-right">
                        <span class="d-block text-normal @if($user->active) text-success @else text-danger @endif">
                            @lang('site::user.active_'.($user->active))
                        </span>
                        <span class="d-block text-normal @if($user->verified) text-success @else text-danger @endif">
                            @lang('site::user.verified_'.($user->verified))
                        </span>
                        <span class="d-block text-normal @if($user->display) text-success @else text-danger @endif">
                            @lang('site::user.display_'.($user->display))
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
