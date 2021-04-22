<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Objednávky') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Detail objednávky - {{$order->order_number}}

                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.orders')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
                            Zpět na přehled
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 grid-rows-1 gap-3">
                        <div class="shadow-md rounded-xl m-2 p-5">
                            <h3 class="font-bold text-xl text-gray-800 leading-tight">Objednávka</h3>
                            <table class="order_detail_table w-full">
                                <tr>
                                    <th class="text-left">Č. objednávky:</th>
                                    <td>{{$order->order_number}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Datum vytvoření:</th>
                                    <td>{{$order->created_at->format('j. n. Y')}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Stav:</th>
                                    <td>{{$order->text_status}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="shadow-md rounded-xl m-2 p-5">
                            <h3 class="font-bold text-xl text-gray-800 leading-tight">Doprava</h3>
                            <table class="order_detail_table w-full">
                                <tr>
                                    <th class="text-left">Název:</th>
                                    <td>{{$order->delivery_method->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Cena:</th>
                                    <td>{{$order->delivery_method->price}}&nbsp;Kč</td>
                                </tr>
                            </table>
                        </div>
                        <div class="shadow-md rounded-xl m-2 p-5">
                            <h3 class="font-bold text-xl text-gray-800 leading-tight">Zákazník</h3>
                            <table class="order_detail_table w-full">
                                <tr>
                                    <th class="text-left">E-mail:</th>
                                    <td>{{$order->user->email}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Jméno:</th>
                                    <td>{{$order->user->full_name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Aktivní:</th>
                                    <td>{{$order->user->active ? 'Ano' : 'Ne'}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Admin:</th>
                                    <td>{{$order->user->admin ? 'Ano' : 'Ne'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="shadow-md rounded-xl m-2 p-5">
                            <h3 class="font-bold text-xl text-gray-800 leading-tight">Platba</h3>
                            <table class="order_detail_table w-full">
                                <tr>
                                    <th class="text-left">Název:</th>
                                    <td>{{$order->payment_method->name}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Cena:</th>
                                    <td>{{$order->payment_method->price}}&nbsp;Kč</td>
                                </tr>
                            </table>
                        </div>
                        <div class="shadow-md rounded-xl m-2 p-5">
                            <h3 class="font-bold text-xl text-gray-800 leading-tight">Adresa</h3>
                            <table class="order_detail_table w-full">
                                <tr>
                                    <th class="text-left">Ulice:</th>
                                    <td>{{$order->address->street}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Č. popisné:</th>
                                    <td>{{$order->address->house_number}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Město:</th>
                                    <td>{{$order->address->city}}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">PSČ:</th>
                                    <td>{{$order->address->zip_code}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-10 px-5">
                        <h3 class="font-bold text-xl text-gray-800 leading-tight">Položky objednávky</h3>
                        <table class="table-auto w-full">
                            <thead class="text-left">
                            <tr>
                                <th colspan="2">Produkt</th>
                                <th>Množství</th>
                                <th>Cena za ks</th>
                                <th>Cena celkem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $product)
                                <tr>
                                    <td>
                                        <a href="{{route('product', $product->product->url)}}">
                                            <img src="{{ route('image.show', ['image' => $product->product->image->id, 'width' => 100]) }}" alt="{{$product   ->product->name}}"/>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('product', $product->product->url)}}">
                                            {{$product->product->full_name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$product->amount}}&nbsp;ks
                                    </td>
                                    <td>
                                        {{$product->price}}
                                    </td>
                                    <td>
                                        {{number_format(($product->amount * $product->price), 2, ',', ' ')}}&nbsp;Kč
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @empty($order->products)
                            <div class="text-center">Objednávka nemá žádné položky</div>
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
