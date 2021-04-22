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
                        {{$category->id ? 'Úprava kategorie: '.$category->name : 'Nová kategorie'}}
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.categories')}}"
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
                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-3">
                            <div>
                                <x-forms.label for="name" :value="__('Název')"/>
                                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name"
                                               :value="old('name', $category->name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="show_in_menu" :value="__('Zobrazit v menu')"/>
                                <input id="show_in_menu" class="inline-block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox"
                                       name="show_in_menu" :value="1" {{($category->show_in_menu || old('show_in_menu')) ? 'checked' : ''}} />

                            </div>
                        </div>
                        <div class="my-2">
                            <x-forms.label for="description" :value="__('Popisek')"/>
                            <x-forms.textarea id="description" class="block mt-1 w-full" name="description">{{old('description', $category->description)}}</x-forms.textarea>
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
    @push('extra-js')
        <script src="{{ asset('libs/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#description',
                language: 'cs',
                branding: false,
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
            });
        </script>
    @endpush
</x-app-layout>
