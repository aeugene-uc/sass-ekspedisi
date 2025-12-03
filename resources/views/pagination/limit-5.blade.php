@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">

        {{-- Previous --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">‹</a>
        </li>

        {{-- Only show 5 pages --}}
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();

            // window of 5 pages centered on current
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $current ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Next --}}
        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">›</a>
        </li>

    </ul>
</nav>
@endif
