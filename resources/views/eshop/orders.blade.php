@extends('layouts.eshop-user')
@section('title', 'Uživatel')
@section('user-content')
    <div class="user-details-orders">
        @if(!empty($orders))
            <table>
                <thead>
                <tr>
                    <th>Číslo objednávky</th>
                    <th>Datum</th>
                    <th>Stav</th>
                    <th>Celková cena</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{route('user.order', $order->id)}}">{{$order->order_number}}</a></td>
                        <td>{{$order->created_at->format('j. n. Y')}}</td>
                        <td>{{$order->text_status}}</td>
                        <td>{{number_format($order->total_price, 2, ',', ' ')}}&nbsp;Kč</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div>Zatím nemáte žádnou objednávku, měl/a byste to napravit!</div>
        @endif
    </div>
@endsection
