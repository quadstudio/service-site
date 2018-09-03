<div class="items-col col-12">
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-5">
                    @include('site::admin.user.component.link')
                    @include('site::admin.user.component.online')
                    @if(!$user->addresses->isEmpty())
                        <div class="mb-2 mb-md-0">
                            <span class="d-block">{{ $user->addresses->where('type_id', 2)->first()->region->name }}
                                &bull; {{ $user->addresses->where('type_id', 2)->first()->locality }}
                            </span>
                        </div>
                    @endif
                    <div>
                         <span class="d-inline-block text-normal @if($user->hasRole('asc')) text-success @else text-danger @endif">
                            @lang('site::user.asc_'.($user->hasRole('asc') ? '1' : '0'))
                        </span>
                        <span class="d-inline-block text-normal @if($user->hasRole('dealer')) text-success @else text-danger @endif">
                            @lang('site::user.dealer_'.($user->hasRole('dealer') ? '1' : '0'))
                        </span>
                    </div>

                </div>
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="mb-2 mb-md-0 text-muted">
                        <span class="d-block">@lang('site::user.created_at'):
                            {{$user->created_at(true)}}</span>
                        <span class="d-block" class="text-muted">@lang('site::user.logged_at'):
                            {{ $user->logged_at() }}</span>
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
