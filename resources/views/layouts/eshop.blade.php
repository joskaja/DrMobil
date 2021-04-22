<html lang="cs-CZ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dr. Mobil - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/eshop.css') }}">
    @stack('extra-css')
</head>
<body>
{{--<h1><a href="/">Dr. Mobil</a></h1>--}}
@include('components.eshop.top-bar')
<div class="container insides">
    @include('components.eshop.categories')
    <div class="container-inner">
    @yield('content')
    </div>
</div>
@include('components.eshop.footer')
@stack('extra-js')
<script src="{{ asset('js/common.js') }}"></script>
</body>
</html>
