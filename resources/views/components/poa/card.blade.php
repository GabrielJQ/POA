@props(['title' => '', 'color' => '', 'icon' => ''])

<div class="card import-card">
    <div class="card-header {{ $color }} text-white">
        <h3 class="card-title">{!! $icon !!} {!! $title !!}</h3>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>