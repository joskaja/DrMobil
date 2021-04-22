<x-app-layout>
    @push('extra-css')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet"/>
    @endpush
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
                        {{$product->id ? 'Úprava produktu: '.$product->name : 'Nový produkt'}}
                    </h3>
                    <div class="flex-1 text-right">
                        <a href="{{route('admin.products')}}"
                           class="inline-block m-0.5 py-1 px-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
                            Zpět na přehled
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    <x-forms.validation-errors class="my-4" :errors="$errors"/>
                    <form method="POST"
                          id="product_form"
                          action="{{$action}}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_properties_json" id="product_properties_json_input" value="">
                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-3">
                            <div>
                                <x-forms.label for="brand" :value="__('Značka')"/>
                                <select id="brand" class="select2 dynamic w-full" name="brand">
                                    <option></option>
                                    @foreach($brands as $key => $brand)
                                        <option
                                            {{ ($key == old('brand', !empty($product->brand) ? $product->brand->id : ''))?'selected':'' }} value="brand_id_{{$key}}"> {{ $brand }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-forms.label for="name" :value="__('Název')"/>
                                <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name"
                                               :value="old('name', $product->name)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="category" :value="__('Kategorie')"/>
                                <select id="category" class="select2 w-full" name="category">
                                    <option></option>
                                    @foreach($categories as $key => $category)
                                        <option
                                            {{ ($key == old('category', !empty($product->category) ? $product->category->id : ''))?'selected':'' }} value="category_id_{{$key}}"> {{ $category }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-forms.label for="price" :value="__('Cena (Kč)')"/>
                                <x-forms.input id="price" class="block mt-1 w-full" type="number" min="1" step="0.01"
                                               name="price"
                                               :value="old('price', $product->price)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="warehouse_amount" :value="__('Množství skladem (ks)')"/>
                                <x-forms.input id="warehouse_amount" class="block mt-1 w-full" type="number" step="1"
                                               name="warehouse_amount"
                                               :value="old('warehouse_amount', $product->warehouse_amount)"
                                               required autofocus/>
                            </div>
                            <div>
                                <x-forms.label for="short_description" :value="__('Krátký popis')"/>
                                <x-forms.textarea id="short_description" class="block mt-1 w-full"
                                                  name="short_description" required>
                                    {{old('short_description', $product->short_description)}}
                                </x-forms.textarea>
                            </div>
                        </div>
                        <div class="my-2">
                            <x-forms.label for="description" :value="__('Popisek')"/>
                            <x-forms.textarea id="description" class="block mt-1 w-full"
                                              name="description">{{old('description', $product->description)}}</x-forms.textarea>
                        </div>
                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-3">
                            <div class="my-2">
                                <x-forms.label for="product_property" :value="__('Vlastnosti produktu')"/>
                                <div class="mb-2">
                                    <select name="product_property" id="product_property" class="select2 dynamic w-2/3">
                                        <option></option>
                                        @foreach($product_properties as $key => $product_property)
                                            <option
                                                value="product_properties_id_{{$key}}"> {{ $product_property }} </option>
                                        @endforeach
                                    </select>
                                    <div id="add_product_property_btn"
                                         class="bg-green-500 mx-1 hover:bg-green-700 curor-pointer inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Přidat vlastnost
                                    </div>
                                </div>
                                <table class="table-auto w-full" id="product_properties_table"
                                       style="{{count($product->properties) > 0 ? '' : 'display:none;'}}">
                                    <thead class="text-left">
                                    <tr>
                                        <th>Vlastnost</th>
                                        <th>Hodnota</th>
                                        <th style="width: 20px">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->properties as $product->property)
                                        <tr data-id="product_properties_id_{{$product->property->property->id}}">
                                            <td class="p-2 font-semibold">{{$product->property->property->name}}</td>
                                            <td class="p-2">
                                                <input type="text" value="{{$product->property->value}}"
                                                       class="product_property_input block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       name="product_property"/>
                                            </td>
                                            <td>
                                                    <span title="Odstranit"
                                                          class="delete_btn cursor-pointer text-red-500 font-bold">X</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="my-2">
                                @if($product->image)
                                    <div class="text-center" id="product_image_wrap">
                                        <a data-fslightbox href="{{route('image.show', $product->image->id)}}">
                                            <img class="max-h-60 w-auto mx-auto"
                                                 src="{{route('image.show', ['image' => $product->image->id, 'width' => 200, 'height' => 200])}}">
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <div id="remove_image_btn"
                                             class="inline items-center px-4 py-2 cursor-pointer border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-red-500 hover:bg-red-700">
                                            Odstranit obrázek a vložit nový
                                        </div>
                                    </div>
                                @endif
                                <div id="image_upload_wrap" style="{{$product->image ? 'display:none;' : ''}}">
                                    <x-forms.label for="image" :value="__('Obrázek')"/>
                                    <input id="image" class="block mt-1 w-full" type="file" name="image"
                                           accept="image/*"
                                        {{$product->image ? '' : 'required'}} />
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
        <script src="{{ asset('libs/fslightbox/fslightbox.js') }}"></script>
        <script src="{{ asset('libs/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script src="{{ asset('libs/jquery/jquery.js') }}" referrerpolicy="origin"></script>
        <script src="{{ asset('libs/select2/js/select2.full.min.js') }}" referrerpolicy="origin"></script>
        <script src="{{ asset('libs/select2/js/i18n/cs.js') }}" referrerpolicy="origin"></script>
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
            $('#remove_image_btn').click(function () {
                $(this).remove();
                $('#product_image_wrap').remove();
                $('#image_upload_wrap').show();
                $('#image').trigger('click');
            })
            $('#add_product_property_btn').click(() => {
                const product_properties_table = $('#product_properties_table');
                const property_select = $('#product_property');
                const property_id = property_select.val();
                if (!property_id) return false;
                const title = $('#product_property option:selected').text();
                property_select.val('').trigger("change");
                const product_property_html = $('<tr data-id="' + property_id + '"><td class="p-2 font-semibold">' + title + '</td><td class="p-2"><input type="text" class="product_property_input block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="product_property"/></td><td><span title="Odstranit" class="delete_btn cursor-pointer text-red-500 font-bold">X</span></td></tr>');
                product_property_html.find('.delete_btn').click(deleteProperty);
                product_properties_table.show().append(product_property_html);
            });
            $('#product_properties_table tbody tr .delete_btn').click(deleteProperty);

            function deleteProperty() {
                $(this).closest('tr').remove();
                if($('#product_properties_table tbody tr').length < 1) $('#product_properties_table').hide();
            }

            $('#product_form').submit(() => {
                let product_properties_json = [];
                $('#product_properties_table tbody tr').each(function () {
                    let tmp_value = $(this).find('.product_property_input').val();
                    if (tmp_value.length > 0) {
                        product_properties_json.push({key: $(this).attr('data-id'), value: tmp_value})
                    }
                });
                $('#product_properties_json_input').val(JSON.stringify(product_properties_json));
            });
            $('.select2').select2({
                language: 'cs',
                placeholder: "Vyberte...",
                allowClear: true
            });
            $('.select2.dynamic').select2(
                {
                    language: 'cs',
                    placeholder: "Vyberte...",
                    allowClear: true,
                    tags: true,
                    createTag: function (params) {
                        const term = $.trim(params.term);

                        if (term === '') {
                            return null;
                        }

                        return {
                            id: 'new_tag_' + term,
                            text: term,
                            newTag: true // add additional parameters
                        }
                    }
                }
            );
        </script>
    @endpush
</x-app-layout>
