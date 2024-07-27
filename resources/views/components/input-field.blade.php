@props([
    'name' => '',
    'type' => 'text',
    'value' => '',
    'id' => '',
    'label' => '',
    'required' => false,
    'class' => '',
    'placeholder' => '',
    'isAjax' => false,
    'dir' => 'vertical',
    'errors' => null,
])
<div class="mb-4">
    @if($dir == 'horizontal')
        <div class="row">
            <div class="col-md-6">
    @endif
    <label class="form-label" for="field-{{ $id }}">{{ $label }}
        @if(isset($required) && $required)
            <span class="text-danger">*</span>
        @endif
    </label>
    @if($dir == 'horizontal')
        </div>
        <div class="col-md-8">
    @endif
    <input type="{{ $type }}" class="form-control {{ $inputClass ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}" id="field-{{ $id }}" name="{{ $name }}" 
    placeholder="{{ $placeholder ?? '' }}" value="{{ $value ?? old($name) }}">
    @if(!isset($isAjax) && $errors->has($name))
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @else
        <div id="error-{{ $id }}" class="text-danger"></div>
    @endif
    @if($type == 'file' && !empty($value))
        <a href="{{ asset($value) }}" target="_blank" class="btn btn-primary mt-2">Lihat Dokumen</a>
    @endif
    
    @if($dir == 'horizontal')
        </div>
    </div>
    @endif
</div>