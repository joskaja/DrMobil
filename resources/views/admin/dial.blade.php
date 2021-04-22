<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Číselník - {{$name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-5 border-b border-gray-200 ">
                    <h3 class="flex-1 bg-white font-bold ">
                        {{$dial->id ? 'Úprava číselníku - '. $name .': '.$dial->name : 'Nová položka číselníku - '.$name}}
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route($route)}}"
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
                        <div>
                            <div>
                                <x-forms.label for="name" :value="__('Název')"/>
                                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name"
                                               :value="old('name', $dial->name)"
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
