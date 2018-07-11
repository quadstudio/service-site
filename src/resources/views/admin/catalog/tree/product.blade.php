<ul>
    @foreach($element['products'] as $product)
        <li><a class="text-primary">{{$product['name']}}</a></li>
    @endforeach
</ul>