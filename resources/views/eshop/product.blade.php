@extends('layouts.eshop')
@section('title', $product->full_name)
@push('extra-css')
@endpush
@section('content')
    <div class="product-detail">
        <h2 class="name">{{$product->full_name}}</h2>
        <a class="photo" data-fslightbox href="{{ route('image.show', ['image' => $product->image->id]) }}">
            <img src="{{ route('image.show', ['image' => $product->image->id, 'width' => 500]) }}" alt="{{ $product->image->name }}">
        </a>

        <p class="short-desc">
            {{$product->short_description}}
        </p>
        @if ($product->warehouse_amount == 0)
            <p class="stock red">
                Na objednání – skladem {{$product->warehouse_amount}}&nbsp;ks
            </p>
        @else
            <p class="stock green">
                skladem {{$product->warehouse_amount}}&nbsp;ks
            </p>
        @endif
        <div class="price">
            <p>
                {{number_format($product->price, 2, ',', ' ')}}&nbsp;Kč
            </p>
            <form method="POST" action="{{route('basket.add')}}">
                @csrf
                <input type="hidden" name="product" value="{{$product->id}}">
                <input type="hidden" name="amount" value="1">
                <button class="special-hover">Vložit do košíku</button>
            </form>
        </div>
        <div class="desc">
            <h3>Popis</h3>
            {!! $product->description !!}
        </div>
        <div class="specs">
            <h3>Specifikace</h3>
        <table>
            @if(!empty($product->properties))
                @foreach($product->properties as $product_property)
                    <tr>
                        <td>{{$product_property->property->name}}</td>
                        <td>{{$product_property->value}}</td>
                    </tr>
                @endforeach
            @endif
        </table>
        </div>
    </div>
@endsection
@push('extra-js')
    <script src="{{ asset('libs/fslightbox/fslightbox.js') }}"></script>
@endpush
