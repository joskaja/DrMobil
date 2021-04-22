@extends('layouts.eshop-user')
@section('title', 'Uživatel')
@section('user-content')
    <div>
        <h1>Objednávka č. {{$order->order_number}}</h1>
        <h2>Objednávka</h2>
        {{$order}}
        <h2>Zákazník</h2>
        {{$order->user}}
        <h2>Adresa dodání</h2>
        {{$order->address}}
        <h2>Doprava</h2>
        {{$order->delivery_method}}
        <h2>Platební metoda</h2>
        {{$order->payment_method}}
        <div>
        <strong>Celková cena objednávky: {{number_format($order->total_price, 2, ',', ' ')}}&nbsp;Kč</strong>
        </div>
        @if(!empty($order->products))
            <table>
                <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Množství</th>
                    <th>Cena za ks</th>
                    <th>Cena celkem</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $order_product)
                    <tr>
                        <td>
                        <a href="{{route('product', $order_product->product->url)}}">
                            <img src="{{ route('image.show', ['image' => $order_product->product->image->id, 'width' => 100]) }}" alt="{{$order_product->product->name}}"/>
                            <span class="product-name">{{$order_product->product->full_name}}</span>
                        </a>
                        </td>
                        <td>
                            {{$order_product->amount}}&nbsp;ks
                        </td>
                        <td>
                            {{$order_product->price}}
                        </td>
                        <td>
                            {{number_format(($order_product->amount * $order_product->price), 2, ',', ' ')}}&nbsp;Kč
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
