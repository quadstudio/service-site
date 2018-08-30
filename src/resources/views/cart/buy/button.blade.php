@can('buy', $product)
    <form class="product-button" data-name="{{$product->name}}" action="{{route('buy', $product)}}" method="post">
        @csrf
        @yield('button')
    </form>
@endcan
