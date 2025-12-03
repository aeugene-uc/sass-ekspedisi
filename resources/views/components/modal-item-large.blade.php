@props([
    'label'
])

<div class="col-12">
    <label class="form-label">{{ $label }}</label>
    {{ $slot }}
</div>