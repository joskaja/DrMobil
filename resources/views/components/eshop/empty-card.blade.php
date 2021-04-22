@props(['title' => 'Nic nenalezeno', 'subtitle'])
<div class="empty-card">
    <div class="empty-card-icon">
        Nejaka ikona
    </div>
    <div class="empty-card-body">
        <h2>{{$title}}</h2>
        @if(!empty($subtitle))
            <p>{{$subtitle}}</p>
        @endif
    </div>
</div>
