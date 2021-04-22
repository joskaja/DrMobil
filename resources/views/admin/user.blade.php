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
                        Úprava uživatele: {{$user->email}}
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.users')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
                            Zpět na přehled
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    <x-forms.validation-errors class="my-4" :errors="$errors" />
                    <form method="POST"
                          action="{{$action}}">
                        @csrf
                        <div class="my2">
                            <div>
                                <x-forms.label for="email" :value="__('E-mail')"/>
                                <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email"
                                               :value="old('email', $user->email)"
                                               required autofocus/>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-3">
                            <div>
                                <x-forms.label for="first_name" :value="__('Jméno')"/>
                                <x-forms.input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                               :value="old('first_name', $user->first_name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="last_name" :value="__('Přijmení')"/>
                                <x-forms.input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                               :value="old('last_name', $user->last_name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="active" :value="__('Aktivní účet')"/>
                                <input id="active" class="inline-block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox"
                                       name="active" :value="1" {{($user->active || old('active')) ? 'checked' : ''}} />
                            </div>
                            <div>
                                <x-forms.label for="admin" :value="__('Admin')"/>
                                <input id="admin" class="inline-block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox"
                                       name="admin" :value="1" {{($user->admin || old('admin')) ? 'checked' : ''}} />
                            </div>
                            <div>
                                <x-forms.label for="street" :value="__('Ulice')"/>
                                <x-forms.input id="street" class="block mt-1 w-full" type="text" name="street"
                                               :value="old('street', $address->street)"/>
                            </div>
                            <div>
                                <x-forms.label for="house_number" :value="__('Číslo popisné')"/>
                                <x-forms.input id="house_number" class="block mt-1 w-full" type="text" name="house_number"
                                               :value="old('house_number', $address->house_number)"/>
                            </div>
                            <div>
                                <x-forms.label for="city" :value="__('Město')"/>
                                <x-forms.input id="city" class="block mt-1 w-full" type="text" name="city"
                                               :value="old('city', $address->city)"/>
                            </div>
                            <div>
                                <x-forms.label for="zip_code" :value="__('PSČ')"/>
                                <x-forms.input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code"
                                                   :value="old('zip_code', $address->zip_code)"/>
                            </div>
                        </div>
                        <div class="my-2 text-center">
                            <x-forms.button class="bg-green-500 hover:bg-green-700">
                                Uložit
                            </x-forms.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
