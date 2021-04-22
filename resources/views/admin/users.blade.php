<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Uživatelé
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        Přehled uživatelů
                    </h3>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>E-mail</th>
                            <th>Jméno</th>
                            <th>Přijmení</th>
                            <th>Aktivní</th>
                            <th>Admin</th>
                            <th>Adresa</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-200">
                                <td class="p-2">{{$user->email}}</td>
                                <td class="p-2">{{$user->first_name}}</td>
                                <td class="p-2">{{$user->last_name}}</td>
                                <td class="p-2">{{$user->active ? 'Ano' : 'Ne'}}</td>
                                <td class="p-2">{{$user->admin ? 'Ano' : 'Ne'}}</td>
                                <td class="p-2">{{!empty($user->address) ? $user->address->full_address : ''}}</td>
                                <td class="p-2" style="width: 190px">
                                    <a href="{{route('admin.users.edit', $user->id)}}"
                                       class="inline-block m-0.5 py-1 px-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none">
                                        Upravit
                                    </a>
                                    <form action="{{route('admin.users.delete', $user->id)}}"
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
