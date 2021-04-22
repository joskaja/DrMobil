@extends('layouts.eshop')
@section('title', 'Uživatel')
@section('content')
    <main>
        @include('components.eshop.user-menu')
        <div class="eshop-user-wrap">
        @yield('user-content')
        </div>
    </main>
@endsection
