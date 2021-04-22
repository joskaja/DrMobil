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
                        {{$delivery_and_payment_method->id ? 'Úprava metody ' : 'Nová metoda '}}
                        {{$type === 'delivery_method' ? 'dopravy' : 'platby'}}
                        {{$delivery_and_payment_method->id ? ': '.$delivery_and_payment_method->name : ''}}

                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.delivery_and_payment_methods')}}"
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
                        <div class="grid grid-cols-2 grid-rows-1 gap-3">
                            <div>
                                <x-forms.label for="name" :value="__('Název')"/>
                                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name"
                                               :value="old('name', $delivery_and_payment_method->name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="description" :value="__('Popisek')"/>
                                <x-forms.input id="description" class="block mt-1 w-full" type="text" name="description"
                                               :value="old('description', $delivery_and_payment_method->description)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="price" :value="__('Cena (Kč)')"/>
                                <x-forms.input id="price" class="block mt-1 w-full" type="number" min="0" step=".1" name="price"
                                               :value="old('price', $delivery_and_payment_method->price)"
                                               required autofocus/>
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
