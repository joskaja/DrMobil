@extends('layouts.eshop')
@push('extra-css')
    <link rel="stylesheet" type="text/css" href="{{asset('libs/rangeslider/rangeslider.css')}}"/>
@endpush
@section('title', $category->name)
@section('content')
    <div class="products">
        <h2>{{$category->name}}</h2>
        <p>
            {!!$category->description!!}
        </p>
        @if(count($products) > 0 || !empty(request()->input('cena')))
            <form id="category_filter_form" method="GET" action="{{request()->fullUrl()}}">
                <strong>Výrobci:</strong>
                <p>
                    @if(!empty($brands))
                        @foreach($brands as $brand)
                            <label for="brand_{{$brand->id}}">
                                <input id="brand_{{$brand->id}}" type="checkbox" name="znacka[]" class="filter_checkbox"
                                       value="{{$brand->id}}" {{!empty(request()->input('znacka')) && in_array($brand->id, request()->input('znacka')) ? 'checked' : ''}}>
                                <span>{{$brand->name}}</span>
                            </label>
                        @endforeach
                    @endif
                </p>
                <strong>Cena:</strong>
                <p>
                    <input type="text" id="price_range" name="cena" value="" disabled readonly/>
                </p>
                <button type="submit" class="button">Filtrovat</button>
                @if(!empty(request()->input('cena')))
                <a href="{{route('category', $category->url)}}" class="button">Resetovat filtrování</a>
                @endif
            </form>
            @if(!empty($sorting_methods))
                <div class="sorting">
                    @foreach($sorting_methods as $key => $sorting_method)
                        <a href="{{request()->fullUrlWithQuery(['seradit' => $key]) }}"
                           class="{{request()->input('seradit') === $key ||
                                (empty(request()->input('seradit')) &&
                                !empty($sorting_method['default']) &&
                                $sorting_method['default']) ? 'active' : ''}}">
                            {{$sorting_method['name']}}
                        </a>
                    @endforeach
                </div>
            @endif
            <div class="products-list">
                @foreach($products as $product)
                    <x-eshop.product-card :product="$product"/>
                @endforeach
            </div>
            {!! $products->onEachSide(3)->links('components.eshop.pagination') !!}
        @else
            <x-eshop.empty-card :title="'Nebyl nalezen žádný produkt'" :subtitle="'V této kategorii nebyl nalezen žádný produkt. Zkuste se prosím vrátit později.'" />
        @endif

    </div>
@endsection
@push('extra-js')
    <script src="{{asset('libs/rangeslider/rangeslider.min.js')}}"></script>
    <script>
        const category_filter_form = document.querySelector('#category_filter_form');
        let min_price = @json($category->min_max_price['min_price']);
        let max_price = @json($category->min_max_price['max_price']);
        let selected_from = @json(!empty($selected_price_from) ? $selected_price_from : $category->min_max_price['min_price']);
        let selected_to = @json(!empty($selected_price_to) ? $selected_price_to : $category->min_max_price['max_price']);
        console.log(selected_from, selected_to);
        const priceRangeSlider = ionRangeSlider('#price_range', {
            type: "double",
            min: min_price,
            max: max_price,
            from: selected_from,
            to: selected_to,
            min_interval: 10,
            force_edges: true,
            postfix: 'Kč',
            grid: true,
            input_values_separator: '-',
            onFinish: (data) => {
                category_filter_form.submit();
            }
        });
        document.querySelectorAll('.filter_checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                category_filter_form.submit();
            });
        });
    </script>
@endpush

