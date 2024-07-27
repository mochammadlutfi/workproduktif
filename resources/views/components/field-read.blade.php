@props([
    'label' => '',
    'value' => '',
    'dir' => 'horizontal',
    'class' => '',
    'id' => '',
])
<div class="{{ ($dir == 'horizontal') ? 'd-flex' : 'd-block'}} mb-2 {{ $class }}">
    <div class="w-50 fw-semibold {{ $dir == 'vertical' ? 'mb-3' : ''}}">
        {{ $label }}
    </div>
    @if ($dir == 'horizontal')
    <div class="mx-2">:</div>
    @endif
    <div class="fw-semibold text-start " id="show-{{ $id }}">
        {!! $value !!}
    </div>
</div>