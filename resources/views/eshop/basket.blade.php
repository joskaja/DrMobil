@extends('layouts.eshop')
@section('title', 'Košík')

@section('content')
    @if(count($basket->items) > 0)
    <div>
        <x-forms.validation-errors class="my-4" :errors="$errors" />

        <form method="POST" action="{{route('order.add')}}">
            @csrf
            <div id="basket-items">
                @if(session()->has('error_message'))
                    <span style="display: block; color: darkred">{{ session('error_message') }}</span>
                @endif
                @if(session()->has('success_message'))
                    <span style="display: block; color: green">{{ session('success_message') }}</span>
                @endif
                @if(session()->has('info_message'))
                    <span class="" style="display: block; color: #b7b700">{{ session('info_message') }}</span>
                @endif
                @foreach($basket->items as $basket_item)
                    <div class="item">
                        <img src="{{ route('image.show', ['image' => $basket_item->product->image->id, 'width' => 150]) }}" alt="{{ $basket_item->product->image->name }}">
                        <a href="{{ route('product', ['product' => $basket_item->product->url]) }}">{{$basket_item->product->full_name}}</a> -
                        <input type="number" name="product[{{$basket_item->product->id}}]"
                               data-basket_item_id="{{$basket_item->id}}"
                               class="product-amount-input"
                               value="{{$basket_item->amount}}" step="1" min="1">&nbsp;ks
                        <span>{{number_format($basket_item->product->price, 2, ',', ' ')}}&nbsp;Kč</span>
                        <a href="{{ route('basket.delete', ['basket_item' => $basket_item->id]) }}">
                            odstranit (ikona)
                        </a>
                    </div>
                @endforeach
            </div>
            <div id="basket-items-total-price">
               Celková cena položek v košíku:  {{number_format($basket->total_price, 2, ',', ' ')}}&nbsp;Kč
            </div>
            <div id="delivery-and-payment">
                <h4>Způsob dopravy</h4>
                @foreach($delivery_methods as $delivery_method)
                    <p>
                        <label for="delivery_method_{{$delivery_method->id}}">
                            <input id="delivery_method_{{$delivery_method->id}}" type="radio" name="delivery_method"
                                   class="session-input"
                                   value="{{$delivery_method->id}}" {{old('delivery_method', $form_data['delivery_method']) == $delivery_method->id ? 'checked' : ''}}>
                            <strong>{{$delivery_method->name}}</strong>
                            - {{number_format($delivery_method->price, 2, ',', ' ')}}&nbsp;Kč
                        </label>
                    </p>
                @endforeach
                <h4>Způsob platby</h4>
                @foreach($payment_methods as $payment_method)
                    <p>
                        <label for="payment_method_{{$payment_method->id}}">
                            <input id="payment_method_{{$payment_method->id}}" type="radio" name="payment_method"
                                   class="session-input"
                                   value="{{$payment_method->id}}" {{old('payment_method', $form_data['payment_method']) == $payment_method->id ? 'checked' : ''}}>
                            <strong>{{$payment_method->name}}</strong>
                            - {{number_format($payment_method->price, 2, ',', ' ')}}&nbsp;Kč
                        </label>
                    </p>
                @endforeach
            </div>
            <div id="delivery-address">
                <h4>Dodací údaje</h4>
                <div>
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" class="session-input"
                           value="{{old('email', $form_data['email'])}}">
                </div>
                <div>
                    <label for="first_name">Jméno</label>
                    <input id="first_name" type="text" class="session-input" name="first_name"
                           value="{{old('first_name', $form_data['first_name'])}}">
                </div>
                <div>
                    <label for="last_name">Přijmení</label>
                    <input id="last_name" type="text" class="session-input" name="last_name"
                           value="{{old('last_name', $form_data['last_name'])}}">
                </div>
                <div>
                    <label for="street">Ulice</label>
                    <input id="street" type="text" class="session-input" name="street"
                           value="{{old('street', $form_data['street'])}}">
                </div>
                <div>
                    <label for="house_number">Číslo popisné</label>
                    <input id="house_number" type="text" class="session-input" name="house_number"
                           value="{{old('house_number', $form_data['house_number'])}}">
                </div>
                <div>
                    <label for="city">Město</label>
                    <input id="city" type="text" class="session-input" name="city"
                           value="{{old('city', $form_data['city'])}}">
                </div>
                <div>
                    <label for="zip_code">PSČ</label>
                    <input id="zip_code" type="text" class="session-input" name="zip_code"
                           value="{{old('zip_code', $form_data['zip_code'])}}">
                </div>
            </div>
            <h4>Souhrn košíku</h4>
            <button type="submit">Odeslat objednávku</button>
        </form>
    </div>
    @else
    <div>
        Nic tu není :(
    </div>
    @endif
@endsection
@push('extra-js')
    <script src="{{asset('js/basket.js')}}"></script>
@endpush
