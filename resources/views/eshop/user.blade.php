@extends('layouts.eshop-user')
@section('title', 'Uživatel')
@section('user-content')
<h2>Profil uzivatele</h2>
<form class="user-details-form" method="POST" action="{{route('user.profile.update', $user->id)}}">
    @csrf
    <div class="gridman">
        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{old('email', $user->email)}}" required readonly/>
        </div>
    </div>
    <div class="gridman">
        <div>
            <label for="first_name">Jméno</label>
            <input id="first_name" type="text" name="first_name" value="{{old('first_name', $user->first_name)}}" required/>
        </div>
        <div>
            <label for="last_name">Přijmení</label>
            <input id="last_name" type="text" name="last_name" value="{{old('last_name', $user->last_name)}}" required />
        </div>
        <div>
            <label for="street">Ulice</label>
            <input id="street" type="text" name="street" value="{{old('street', $address->street)}}"/>
        </div>
        <div>
            <label for="house_number">Číslo popisné</label>
            <input id="house_number" type="text" name="house_number" value="{{old('house_number', $address->house_number)}}"/>
        </div>
        <div>
            <label for="city">Město</label>
            <input id="city" type="text" name="city" value="{{old('city', $address->city)}}"/>
        </div>
        <div>
            <label for="zip_code">PSČ</label>
            <input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" value="{{old('zip_code', $address->zip_code)}}"/>
        </div>
    </div>
    <div style="text-align: center">
        <button>
            Uložit
        </button>
    </div>
</form>
@endsection
