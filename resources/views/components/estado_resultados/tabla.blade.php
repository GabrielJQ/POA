@props([
    'conceptos' => collect(),
    'matriz' => []
])

<div class="table-responsive">
    @include('estado_resultados._tabla')
</div>