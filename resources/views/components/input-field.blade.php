@props([
    'placeholder' => '',
    'id' => '',
    'label' => '',
    'type' => 'text',
    'name' => '',
    'max' => '',
    'options' => [],
    'value' => '',
    'disabled' => false,
    'isAjax' => false,
    'inputClass' => '',
])
<div class="mb-4">
    <label class="form-label" for="field-{{ $id }}">{{ $label }}
        @if(isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type }}" class="form-control {{ $inputClass ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}" id="field-{{ $id }}" name="{{ $name }}" 
    placeholder="{{ $placeholder ?? '' }}" max="{{ $max }}" value="{{ $value ?? old($name) }}">
    @if($isAjax == false && $errors->has($name))
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @else
        <div id="error-{{ $id }}" class="text-danger"></div>
    @endif
    @if($type == 'file' && !empty($value))
        <a href="{{ asset($value) }}" target="_blank" class="btn btn-primary mt-2">Lihat Dokumen</a>
    @endif
    
</div>