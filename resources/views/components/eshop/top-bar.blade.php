<nav class="navbar">
    <div class="insides">
    <a class="logo" href="/">
        <img src="{{asset('assets/dr-mobil-rgb-b.svg')}}" alt="logo Dr.Mobil"/>
    </a>
    <form method="GET" action="{{route('search')}}">
        <input type="text" name="q" placeholder="Hledejte rychle a přehledně!" value="{{!empty(request()->input('q')) ? request()->input('q') : ''}}"/>
        <button type="submit">Hledat</button>
    </form>
    <div class="show-mobile spacer"></div>
    @auth
    <div class="dropdown-parent nav-user">
         <span class="dropdown-clicker user-profile">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="namen hide-mobile">{{auth()->user()->full_name}}</span>
         </span>
            <ul class="dropdown-child user-dropdown">
                @if (auth()->user()->admin)
                <li><a href="{{route('admin.dashboard')}}">Administrace</a></li>
                @endif
                <li><a href="{{route('user.profile.edit')}}">Můj účet</a></li>
                <li><a href="{{route('logout')}}">Odhlásit se</a></li>
            </ul>
    @endauth
    @guest
    <div class="nav-user">
        <a class="nav-anchor" href="{{route('login')}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span class="namen hide-mobile">
                Přihlásit se
            </span>
        </a>
        <a class="hide-mobile nav-anchor" href="{{route('register')}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span class="namen hide-mobile">
                Registrovat se
            </span>
        </a>
    @endguest
    </div>
        <a class="nav-anchor" href="{{route('basket')}}" data-basket="{{count($eshop_basket->items)}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="namen hide-mobile">
            {{number_format($eshop_basket->total_price, 0, ',', ' ')}}&nbsp;Kč
            </span>
        </a>
            <div id="menu-toggler" class="show-mobile nav-anchor">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
    </div>
</nav>
