@foreach (($fields ?? []) as $field)
	@if (!($field['condition'] ?? true))
		@continue
	@endif
    @php
        $inputType = $field['tag'] ?? 'text';
        $label = $field['label'] ?? '';
        $attributes = $field['attributes'];
        @endphp
    @switch($inputType)
    @case('text')
        @php
        if (isset($attributes['name'])) {
            $name = $attributes['name'];
        }
        if (isset($attributes['type'])) {
            $type = $attributes['type'];
        }
        if (isset($attributes['maxlength'])) {
            $maxlength = $attributes['maxlength'];
        }
        if (isset($attributes['value'])) {
            $value = $attributes['value'];
        }
        if (isset($attributes['placeholder'])) {
            $placeholder = $attributes['placeholder'];
        }
        if (isset($attributes['required'])) {
            $required = ($attributes['required'] == 'true' ? 'required' : '');
        }
        if (isset($attributes['disabled'])) {
            $disabled = ($attributes['disabled'] == 'true' ? 'disabled' : '');
        }
        @endphp
        <div>
            <label for="{{ $name }}" class="label">{{ $label }}</label>
            <input type="{{ $type ?? 'text'}}" 
            name="{{ $name ?? '' }}" 
            class="form-control" 
            placeholder="{{ $placeholder ?? '' }}" 
            maxlength="{{ $maxlength ?? '' }}"
            value="{{ $value ?? '' }}"
            {{ $required ?? '' }}
            {{ $disabled ?? '' }}
            >
        </div>
            @break
    @case('select')
        @php
        $options = $attributes['options'] ?? [];
        if (isset($attributes['name'])) {
            $name = $attributes['name'];
        }
        if (isset($attributes['value'])) {
            $value = $attributes['value'];
        }
        if (isset($attributes['required'])) {
            $required = ($attributes['required'] == 'true' ? 'required' : '');
        }
        if (isset($attributes['disabled'])) {
            $disabled = ($attributes['disabled'] == 'true' ? 'disabled' : '');
        }
        @endphp
        <div>
        <label for="{{ $name }}" class="label" >{{ $label }}</label>
        <select class="form-control" name="{{ $name }}" {{ $required }} {{ $disabled }}>
            <option class="form-control select-items">-</option>
            @foreach ($options as $option)
                <option class="form-control select-items">{{ $option }}</option>
            @endforeach
        </select>
    </div>
    @break
        @default
            
    @endswitch
@endforeach