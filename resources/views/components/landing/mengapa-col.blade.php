@props(['number', 'title', 'body'])

<div class="col-md-6 col-lg-3">
    <div class="p-4 h-100">
        <h1 style="color: #f15a25; font-size: 3rem;" class="fw-bold mb-3">{{ $number }}</h1>
        <h5 class="fw-bold mb-3">{{ $title }}</h5>
        <p class="text-muted mb-0">
            {{  $body }}
        </p>
    </div>
</div>