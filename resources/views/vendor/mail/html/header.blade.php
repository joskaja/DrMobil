<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Dr.Mobil')
<img src="{{asset('assets/dr-mobil-rgb-b.png')}}" class="logo" alt="Dr. Mobil">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
