<tr>
    <td>@include('site::admin.user.component.link')
	<br />@lang('site::user.active')<span class="text-normal @if($user->active) text-success @else text-danger @endif">@lang('site::user.active_ico_'.($user->active))</span>
	<br />@lang('site::user.display')<span class="text-normal @if($user->display) text-success @else text-danger @endif"> @lang('site::user.display_ico_'.($user->display))</span>
    <li style="list-style-type: none;">@lang('site::user.logged_at_l') @if($user->logged_at){{$user->logged_at->format('d.m.Y')}}@endif</li>
    <li style="list-style-type: none;">@lang('site::user.created_at_l') @if($user->created_at){{$user->created_at->format('d.m.Y')}}@endif</li>
	</td>
    <td>{{ optional($user->region)->name }} @if(($addresses = $user->addresses()->where('type_id', 1)->get())->isNotEmpty()) / {{ $addresses[0]->locality }} @endif</td>
    <td> @if(($addresses = $user->addresses()->where('type_id', 6)->get())->isNotEmpty())
	@foreach($addresses as $address)
	{{ $address->locality }} 
	@endforeach
	@endif
	</td>
    <td>@foreach($user->roles as $role) <li style="list-style-type: none;">{{$role->title}}</li> @endforeach</td>
    <td>
        @foreach($user->authorization_accepts as $authorization) 
					<li style="list-style-type: none;">{{$authorization->role->description}} {{$authorization->type->name}} {{$authorization->type->brand->name}}</li>
				@endforeach
    </td>
	
<!-- Сумма заказов за период выбранный в фильтре. -->
<td></td>

<!-- Кол-во заказов за период. -->
<td></td>

<!-- Кол-во заказов всего. -->
<td><a href="{{ route('admin.orders.index', ['filter[user]='.$user->id]) }}" target="_blank">{{$user->orders()->count()}}</a></td>

<!-- Даты и суммы 3-х последних заказов. -->
<td>
@if($user->orders()->count() > 0)
	@foreach($user->orders_last_3 as $order)
		<li style="list-style-type: none;"><a href="{{route('admin.orders.show', $order)}}" target="_blank">{{$order->created_at->format('d.m.Y')}} <br /> {{ $order->total(978, false, true) }} </a><br /> <br /> </li>
	@endforeach
@endif
</td>
<!-- Сумма входящих заказов за период. -->
<td></td>
<!-- Кол-во входящих заказов за период. -->
<td></td>
<!-- Кол-во входящих заказов всего. -->
<td></td>
<!-- Кол-во АГР за период. -->
<td></td>
<!-- Кол-во актов за календарный текущий квартал. -->
<td></td>
<!-- Даты 3-х последних АГР. -->
<td></td>
<!-- Даты последнего обновления складов пользователя. -->
<td></td>
<!-- Количество запчастей на складах. -->
<td></td>
<!-- Стоимость всех запчастей на складах. -->
<td></td>
	
	
	
	
	
	
	
	
	
	
   
</tr>
