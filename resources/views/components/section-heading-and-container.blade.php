@props([
    'heading_1',
    'heading_2',
    'center' => false,
    'use_default_row' => true,
])

@if ($use_default_row)
    <div class="row mb-5">
@endif
    <div class="{{ $center ? 'container text-center' : 'col-lg-6 mb-4 mb-lg-0' }}">
        <h2 class="display-5 fw-bold mb-4">
            {{ strtoupper($heading_1) }}
            <br>
            <span style="color: #f15a25;">
                {{ strtoupper($heading_2) }}
            </span>
        </h2>
        <div 
            class="mb-4" 
            style="{{ $center ? 'margin: 0 auto;' : '' }} width: 80px; height: 3px; background-color: #f15a25;">
        </div>
        {{ $slot }}
    </div>
@if ($use_default_row)
    </div>
@endif
