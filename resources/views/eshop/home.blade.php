@extends('layouts.eshop')
@section('title', 'Váš e-shop s mobilními telefony')
@push('extra-css')
    <link rel="stylesheet" href="{{ asset('libs/splide/css/splide-core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/splide/css/custom.splide.css') }}">
@endpush
@section('content')
    <div id="homepage">
        @if(count($slides))
            <div class="splide" id="splider">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($slides as $slide)
                            <li class="splide__slide">
                            <a href="{{$slide->target_url}}" title="{{$slide->name}}" target="_blank">
                                <img src="{{route('image.show',['image' => $slide->image->id, 'width' => 1200, 'height' => 400])}}" alt="{{$slide->image->name}}"/>
                                <span class="stext">
                                    <span class="slitle">{{$slide->name}}</span>
                                    <span class="prph">{{$slide->text}}</span>
                                </span>
                            </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="splide__progress">
                    <div class="splide__progress__bar">
                    </div>
                </div>
            </div>

        @endif
            <h1>Dr. Mobil - Váš e-shop s mobilními telefony</h1>

        @foreach($eshop_categories as $category)
            @if(count($category->products) > 0)
                <div class="category-box">
                    <h2><a class="arrowed" href="{{route('category', $category->url)}}">{{$category->name}}</a></h2>
                    <div class="products-list">
                        @foreach($category->products()->orderBy('created_at', 'desc')->limit(4)->get() as $product)
                            <x-eshop.product-card :product="$product"/>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
@push('extra-js')
    <script src="{{ asset('libs/splide/js/splide.min.js') }}"></script>
    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#splider', {
                width: 'calc(1400px - 5rem - 180px)',
                arrows: false,
                height: '400px',
                resetProgress: false,
                pauseOnFocus: false,
                autoplay: true,
                type: 'loop',
                interval: 5000,
                breakpoints: {
                    1400: {
                        width: 'calc(98vw - 5rem - 180px)'
                    },
                    768: {
                        width: 'calc(100vw - 5rem - 180px)',
                        height: '300px'
                    },
                    540: {
                        width: 'calc(100vw - 2rem)',
                        height: '200px'
                    }
                }
            }).mount();
        } );
    </script>
@endpush
