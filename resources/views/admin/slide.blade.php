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
                        {{$slide->id ? 'Úprava slidu: '.$slide->name : 'Nový slide'}}
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.homepage')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
                            Zpět na přehled
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    <x-forms.validation-errors class="my-4" :errors="$errors" />
                    <form method="POST"
                          enctype="multipart/form-data"
                          action="{{$action}}">
                        @csrf
                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-3">
                            <div>
                                <x-forms.label for="name" :value="__('Název')"/>
                                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name"
                                               :value="old('name', $slide->name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="text" :value="__('Text')"/>
                                <x-forms.input id="text" class="block mt-1 w-full" type="text" name="text"
                                               :value="old('text', $slide->text)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="target_url" :value="__('Cílová URL')"/>
                                <x-forms.input id="target_url" class="block mt-1 w-full" type="url" name="target_url"
                                               :value="old('target_url', $slide->target_url)"
                                               required autofocus/>
                            </div>
                            <div>
                                @if($slide->image)
                                    <div class="text-center" id="slide_image_wrap">
                                        <a data-fslightbox href="{{route('image.show', $slide->image->id)}}">
                                            <img class="max-h-60 w-auto mx-auto"
                                                 src="{{route('image.show', ['image' => $slide->image->id, 'width' => 200, 'height' => 200])}}">
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <div id="remove_image_btn"
                                             class="inline items-center px-4 py-2 cursor-pointer border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-red-500 hover:bg-red-700">
                                            Odstranit obrázek a vložit nový
                                        </div>
                                    </div>
                                @endif
                                <div id="image_upload_wrap" style="{{$slide->image ? 'display:none;' : ''}}">
                                    <x-forms.label for="image" :value="__('Obrázek')"/>
                                    <input id="image" class="block mt-1 w-full" type="file" name="image"
                                           accept="image/*"
                                        {{$slide->image ? '' : 'required'}} />
                                </div>
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
    @push('extra-js')
        <script>
            document.querySelector('#remove_image_btn').addEventListener('click', function (e) {
                e.target.remove();
                document.querySelector('#slide_image_wrap').remove();
                document.querySelector('#image_upload_wrap').style.display = "block";
                document.querySelector('#image').trigger('click');
            })
        </script>
    @endpush
</x-app-layout>
