@auth
<a href="{{route('cart')}}" class="cart-nav">
    <i class="fa fa-2x fa-shopping-cart"></i>
    <span class="badge" style="font-size: 1.3em;">{{ Cart::quantity() }}</span>
</a>
@include('site::cart.modal.add')
@endauth