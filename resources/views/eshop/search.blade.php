@extends('layouts.eshop')
@section('title', 'Vyhledávání - ' . $query)
@section('content')
    <div>
        <h1>Vyhledáno - "{{$query}}"</h1>
        @if(count($products) > 0)
            <div class="products-list">
                @foreach($products as $product)
                    <x-eshop.product-card :product="$product"/>
                @endforeach
            </div>
        @else
            <div>
                <x-eshop.empty-card :title="'Nic nenalezeno'" :subtitle="'Na vámi vyhledávaný dotaz ”'. $query .'” nebyl nalezen žádný výrobek'" />
            </div>
        @endif
    </div>
@endsection
