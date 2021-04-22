@component('mail::message')
    <h1>Dobrý den,</h1>
    @if(in_array($order->status, [0,2,3,4]))
        <p>dovolujeme si Vás informovat, že se změnil stav vaší objednávky č. <strong>{{$order->order_number}}</strong>
            z e-shopu <a href="{{route('home')}}">Dr. Mobil</a>.
            Nový stav vaší objednávky je <strong>"{{$order->text_status}}"</strong></p>
    @elseif($order->status == 1)
        <p>potvrzujeme přijetí Vaší nové objednávky č. <strong>{{$order->order_number}}</strong> z e-shopu Dr. Mobil.
            O jejím dalším zpracování Vás budeme v brzské době informovat. Níže nalezente přehled Vaší objednávky</p>
    @endif
    <p>V případě dotazů nás kontaktujte buď na e-mail <a href="mailto:drmobil@joska-jan.cz">drmobil@joska-jan.cz</a>,
        nebo na telefonním čísle <a href="tel:+420739735745">+420 739 735 745</a>.</p>
    <h2>Dodací adresa</h2>
    <p>
        {{$order->user->full_name}}<br>
        {{$order->address->full_address}}
    </p>
    <h2>Doprava a platba</h2>
    <p>
        {{$order->delivery_method->name}} - {{number_format($order->delivery_method->price, 2, ',', ' ')}}&nbsp;Kč <br>
        {{$order->payment_method->name}} - {{number_format($order->payment_method->price, 2, ',', ' ')}}&nbsp;Kč
    </p>
    <h2>Produkty vaší objednávky:</h2>
    <div>
        @if(!empty($order->products))
            <table style="width: 100%">
                <thead>
                <tr>
                    <th colspan="2">Produkt</th>
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
                                <img
                                    src="{{route('image.show', ['image' => $order_product->product->image->id, 'width' => 100])}}"
                                    alt="{{$order_product->product->name}}"
                                    style="min-width: 75px !important;"/>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('product', $order_product->product->url)}}" class="product-name">
                                {{$order_product->product->name}}
                            </a>
                        </td>
                        <td>
                            {{$order_product->amount}}&nbsp;ks
                        </td>
                        <td>
                            {{number_format(($order_product->price), 2, ',', ' ')}}&nbsp;Kč
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
    <p>S přátelským pozdravem,<br>
        Váš tým Dr. Mobil</p>
@endcomponent
