<tr>
    <td>@include('site::admin.user.component.link')
    </td>
    <td>@if(($addresses = $user->addresses()->where('type_id', 2)->get())->isNotEmpty())
            {{$addresses[0]->region->name }} @endif </td>
    <td>@if(($addresses = $user->addresses()->where('type_id', 2)->get())->isNotEmpty()) {{ $addresses[0]->locality }} @endif</td>

    <td class="text-center">@if(( $user->roles()->where('id', 2)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.active_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 3)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.asc_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 9)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.csc_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 4)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.dealer_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 8)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.distr_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 7)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.gendistr_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">@if(( $user->roles()->where('id', 10)->get()->isNotEmpty() ))<span
                class="text-normal text-success">@lang('site::user.active_ico_1')</span> @else <span
                class="text-normal text-danger">@lang('site::user.active_ico_0')</span> @endif</td>
    <td class="text-center">
        <span class="text-normal @if($user->active) text-success @else text-danger @endif">@lang('site::user.active_ico_'.($user->active))</span>
    </td>
    <td class="text-center">
        <span class="text-normal @if($user->verified) text-success @else text-danger @endif">@lang('site::user.verified_ico_'.($user->verified))</span>
    </td>
    <td class="text-center">
        <span class="text-normal @if($user->display) text-success @else text-danger @endif"> @lang('site::user.display_ico_'.($user->display))</span>
    </td>

    <td>@if($user->created_at())
            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user->created_at)->format('d.m.Y')}}
        @endif </td>

    <td>@if($user->logged_at())
            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user->logged_at)->format('d.m.Y')}}</td>
    @endif
    <td>
        @if($order = $user->orders()->latest()->first())
            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d.m.Y')}}
        @endif
    </td>
</tr>
