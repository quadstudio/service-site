<form action="{{route('buy')}}" method="post">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product_id }}">
    <input type="hidden" name="name" value="{{ $name }}">
    <input type="hidden" name="price" value="{{ $price }}">
    <input type="hidden" name="currency_id" value="{{ $currency_id }}">

    @if(config('cart.weight', false) === true)
        <input type="hidden" name="weight" value="{{ $weight }}">
    @endif

    @if(config('cart.image', false) === true)
        <input type="hidden" name="image" value="{{ $image }}">
    @endif

    @if(config('cart.sku', false) === true)
        <input type="hidden" name="sku" value="{{ $sku }}">
    @endif

    @if(config('cart.brand', false) === true)
        <input type="hidden" name="brand_id" value="{{ $brand_id }}">
        <input type="hidden" name="brand" value="{{ $brand }}">
    @endif

    @if(config('cart.unit', false) === true)
        <input type="hidden" name="unit" value="{{ $unit }}">
    @endif

    @if(config('cart.url', false) === true)
        <input type="hidden" name="url" value="{{ $url }}">
    @endif

    @if(config('cart.availability', false) === true)
        <input type="hidden" name="availability" value="{{ (int)$availability }}">
    @endif
    @yield('button')
</form>