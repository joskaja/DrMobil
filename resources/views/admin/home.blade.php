<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Slider hlavní stránky
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled slidů
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.homepage.add')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none">
                            Přidat nový slide
                        </a>
                    </div>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>Obrázek</th>
                            <th>Název</th>
                            <th>Text</th>
                            <th>URL</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($slides as $slide)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2">
                                    <div class="bg-white w-12 h-12">
                                        <img src="{{route('image.show', ['image' => $slide->image->id, 'height' => 50, 'width' => 50])}}"
                                             alt="{{$slide->image->name}}">
                                    </div>
                                </td>
                                <td class="p-2">{{$slide->name}}</td>
                                <td class="p-2">{{$slide->text}}</td>
                                <td class="p-2 underline"><a href="{{$slide->target_url}}" target="_blank">{{$slide->target_url}}</a></td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.homepage.edit', ['slide' => $slide->id])}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.homepage.delete', ['slide' => $slide->id])}}"
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
