@props([
    'label'
])

<div class="col-12 col-md-6">
    <label class="form-label">{{ $label }}</label>
    {{ $slot }}
</div>