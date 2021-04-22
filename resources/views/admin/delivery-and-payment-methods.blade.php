<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Způsoby dopravy a platby') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled způsobů dopravy
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.delivery_method.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat nový způsob dopravy
                        </a>
                    </div>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>Název</th>
                            <th>Popis</th>
                            <th>Cena</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($delivery_methods as $delivery_method)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2 font-semibold">{{$delivery_method->name}}</td>
                                <td class="p-2">{{$delivery_method->description}}</td>
                                <td class="p-2">{{number_format($delivery_method->price, 2, ',', ' ')}}&nbsp;Kč</td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.delivery_method.edit', ['delivery' => $delivery_method->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.delivery_method.delete', ['delivery' => $delivery_method->id])}}"
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
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled způsobů platby
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.payment_method.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat nový způsob platby
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>Název</th>
                            <th>Popis</th>
                            <th>Cena</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payment_methods as $payment_method)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2 font-semibold">{{$payment_method->name}}</td>
                                <td class="p-2">{{$payment_method->description}}</td>
                                <td class="p-2">{{number_format($payment_method->price, 2, ',', ' ')}}&nbsp;Kč</td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.payment_method.edit', ['payment' => $payment_method->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.payment_method.delete', ['payment' => $payment_method->id])}}"
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
