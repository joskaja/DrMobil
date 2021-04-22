@extends('layouts.eshop')
@section('title', 'Děkujeme za objednávku')
@section('content')
    <main>
        <h2>Děkujeme za objednávku</h2>
        <p>Vaše objednávka č. <strong>{{$order->order_number}}</strong> byla úspěšně odeslána.</p>
        <p>Pokud jste zvolil/a platbu předem, objednávka bude odeslána ihned po obdržení platby.</p>
        <p>Platbu můžete provést převodem na účet s níže uvedenými údaji.</p>
        <table>
            <tr>
                <td>Číslo účtu: </td>
                <td>12345678 / 0800</td>
            </tr>
            <tr>
                <td>Variabilní symbol: </td>
                <td>{{$order->id}}</td>
            </tr>
        </table>
    </main>
@endsection
