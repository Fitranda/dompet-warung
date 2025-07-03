@props(['value'])

<label {{ $attributes->merge(['class' => 'mobile-form-label']) }}>
    {{ $value ?? $slot }}
</label>
