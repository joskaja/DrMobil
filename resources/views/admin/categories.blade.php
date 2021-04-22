<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled kategorii
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.categories.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat novou kategorii
                        </a>
                    </div>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>Název</th>
                            <th>URL</th>
                            <th>Popis</th>
                            <th>Menu</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2 font-semibold underline">
                                    <a href="{{route('category', ['category' => $category->url])}}" target="_blank">
                                        {{$category->name}}
                                    </a>
                                </td>
                                <td class="p-2">{{$category->url}}</td>
                                <td class="p-2">{!! \Illuminate\Support\Str::limit(strip_tags($category->description), 80, '...') !!}</td>
                                <td class="p-2">{{$category->show_in_menu ? 'Ano' : 'Ne'}}</td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.categories.edit', ['category' => $category->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.categories.delete', ['category' => $category->id])}}"
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
