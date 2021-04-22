<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Objednávky
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled objednávek
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.homepage.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat objednávku
                        </a>
                    </div>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>Číslo objednávky</th>
                            <th>Uživatel</th>
                            <th>Dodání</th>
                            <th>Částka</th>
                            <th>Datum</th>
                            <th>Stav</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr class="group">
                                <td class="px-0.5 group-hover:bg-gray-100">
                                    {{$order->order_number}}
                                </td>
                                <td class="px-0.5 group-hover:bg-gray-100">
                                    {{$order->user->full_name}} - {{$order->user->email}} <br>
                                    {{$order->address->full_address}}
                                </td>

                                <td class="px-0.5 group-hover:bg-gray-100">
                                    {{$order->delivery_method->name}} -
                                    {{$order->payment_method->name}}

                                </td>
                                <td class="px-0.5 group-hover:bg-gray-100">
                                    {{number_format($order->total_price, 2, ',', ' ')}}&nbsp;Kč
                                </td>
                                <td class="px-0.5 group-hover:bg-gray-100">
                                  {{$order->created_at->format('j. n. Y')}}
                                </td>
                                <td class="text_status_col group-hover:bg-gray-100">
                                    {{$order->text_status}}
                                </td>
                                <td class="px-0.5 group-hover:bg-gray-100">
                                    @if($order->status < 3)
                                    <div data-new_status="{{($order->status+1)}}" data-order="{{($order->id)}}"
                                         class="order_status_btn text-center cursor-pointer inline-block m-0.5 py-1 px-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
                                        {{$order_statuses[$order->status+1]}}
                                    </div><br>
                                    @endif
                                    <a href="{{route('admin.orders.show', ['order' => $order->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Detail
                                    </a>
                                    <form action="{{route('admin.orders.delete', ['order' => $order->id])}}"
                                          method="POST" class="inline-block m-0.5">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"
                                                class="py-1 px-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none">
                                            Odstranit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $orders->onEachSide(3)->links('components.admin.pagination') !!}

                </div>
            </div>
        </div>
    </div>
    @push('extra-js')
        <script src="{{ asset('libs/jquery/jquery.js') }}"></script>
        <script>
            let order_statuses = @json($order_statuses);
            $('.order_status_btn').click(function () {
                let order_status_button = $(this);
                if (!order_status_button.hasClass('disabled')) {
                    order_status_button.addClass('disabled');
                    let order = parseInt(order_status_button.attr('data-order'));
                    let new_status = parseInt(order_status_button.attr('data-new_status'));
                    $.get("{{route('admin.orders.status')}}?order="+ order +"&status="+ new_status +"",
                        function (result) {
                        console.log(result);
                        if(result.status === 'ok') {
                            order_status_button.text(order_statuses[new_status + 1]);
                            order_status_button.attr('data-new_status', (new_status + 1));
                            order_status_button.closest('tr').find('.text_status_col').text(order_statuses[new_status]);
                            if (new_status === 3) order_status_button.remove();
                        }
                        order_status_button.removeClass('disabled');
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
