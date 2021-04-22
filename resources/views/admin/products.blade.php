<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Produkty
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled produktů
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.products.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat nový produkt
                        </a>
                    </div>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Značka</th>
                            <th>Název</th>
                            <th>Kategorie</th>
                            <th>Popis</th>
                            <th style="width: 120px">Cena</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="bg-white w-12 h-12">
                                        <img src="{{route('image.show', ['image' => $product->image->id, 'height' => 50, 'width' => 50])}}"
                                             alt="{{$product->image->name}}">
                                    </div>
                                </td>
                                <td class="p-2">{{$product->brand->name}}</td>
                                <td class="p-2 font-semibold underline">
                                    <a href="{{route('product', ['product' => $product->url])}}" target="_blank">
                                        {{$product->name}}
                                    </a>
                                </td>
                                <td class="p-2">{{$product->category->name}}</td>
                                <td class="p-2">{{$product->short_description}}</td>
                                <td class="p-2">{{number_format($product->price, 2, ',', ' ')}}&nbsp;Kč</td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.products.edit', ['product' => $product->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.products.delete', ['product' => $product->id])}}"
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
                    {!! $products->onEachSide(3)->links('components.admin.pagination') !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
