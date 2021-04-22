@extends('layouts.eshop')
@section('title', 'O nás')

@section('content')
    <h1>Dr.Mobil - Váš e-shop s mobilními telefony</h1>
    <p>
        Společnost Dr. Mobil s.r.o. byla založena v roce 2004 a zároveň v tomto roce otevřela svoji první kamennou
        pobočku. Ta se nachází v Pardubicích za Machoňovou pasáží a denně obsluhuje desítky zákazníků a pomahá jim s
        jejich potřebami. Z počátku byly v sortimetntu společnosti zařazeny pouze mobilní telefony. V dnešní době se
        paleta produktů rozrostla i o jejich příslušenství a další doplňky. Naleznete u nás například sluchátka,
        pouzdra, kabely, tvrzená skla a mnoho dalších produktů, které se vám při nákupu vašeho nového zařízení budou
        hodit.
    </p>
    <p>
        E-shop naší spoelčnosti byl založen z nutnosti dočasně uzavřít pobočku. Chceme tedy našim zákazníkům nabídnout
        možnost, jak si u nás zboží nakoupit z pohodlí jejich domovů. Nakoupené zboží si pak mohou vyzvednout buď na
        naší pobočce, nebo jim bude zasláno až domů.
    </p>
    <p style="text-align: center">
        Nevíte si rady s výběrem a nákupem zboží?
    </p>
    <p style="text-align: center; margin-top: 10px">
        <a href="{{route('contact')}}" class="button-general special-hover">Kontaktujte nás</a>
    </p>

@endsection
