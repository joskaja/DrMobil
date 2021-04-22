@if($product->id)
<div class="product-card">
    <a class="p-image" href="{{ route('product', ['product' => $product->url]) }}">
        <img src="{{ route('image.show', ['image' => $product->image->id, 'width' => 300]) }}" alt="{{ $product->image->name }}">
    </a>
    <a class="p-name arrowed" href="{{ route('product', ['product' => $product->url]) }}">{{ $product->full_name }}</a>
    <div class="p-price-block">
        <div class="left-wrap">
            <span class="price">{{ number_format($product->price, 2, ',', ' ') }} Kč</span>
            @if ($product->warehouse_amount == 0)
                <span class="availability red">Na objednání</span>
            @elseif ($product->warehouse_amount <= 5)
                <span class="availability green">Skladem {{ $product->warehouse_amount }} ks</span>
            @else
                <span class="availability green">Skladem 5+ ks</span>
            @endif
        </div>
        <form method="POST" action="{{route('basket.add')}}">
            @csrf
            <input type="hidden" name="product" value="{{$product->id}}">
            <input type="hidden" name="amount" value="1">
            <button class="special-hover">Vložit do košíku</button>
        </form>
    </div>
    <p>{{ $product->short_description }}</p>
</div>
@endif
