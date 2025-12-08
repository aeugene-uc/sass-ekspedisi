@if ($paginator->hasPages())
  <div class="mt-4 flex justify-center">
    <div class="btn-group">
      {{-- Previous --}}
      <button
        wire:click="previousPage"
        @if($paginator->onFirstPage()) disabled @endif
        class="btn"
      >«</button>

      {{-- Page numbers --}}
      @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        <button
          wire:click="gotoPage({{ $page }})"
          class="btn {{ $page == $paginator->currentPage() ? 'btn-primary' : '' }}"
        >{{ $page }}</button>
      @endforeach

      {{-- Next --}}
      <button
        wire:click="nextPage"
        @if(!$paginator->hasMorePages()) disabled @endif
        class="btn"
      >»</button>
    </div>
  </div>
@endif
