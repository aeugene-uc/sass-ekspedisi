@props(['list', 'grid_id'])

<div class="row g-4">
    @php
        $i = 1;
        $total = $list->count();
    @endphp

    @foreach ($list as $item)
        @if ($i % 6 == 1)
            <div class="{{ $grid_id }}_grid container @if($i > 1) collapse mt-4 @endif" id="collapse_{{$grid_id}}_{{ (int) ($i / 6) }}">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @endif
                    <div class="col d-flex">
                        <div class="card flex-fill border-0 shadow-sm">
                            <div class="card-image position-relative overflow-hidden rounded-top">
                                <img src="{{ asset('images/' . $grid_id . '/' . $item->image) }}" 
                                    class="card-img-top object-fit-cover w-100 h-100" 
                                    alt="{{ $item->title }}">
                                <div class="position-absolute top-0 start-0 w-100 h-100" 
                                    style="background-color: rgba(0,0,0,0.4);"></div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $item->title }}</h5>
                                <p class="card-text text-muted mb-1">{{ $item->text_1 }}</p>

                                @if(property_exists($item, 'text_2'))
                                    <p class="card-text text-muted">{{ $item->text_2 }}</p>
                                @endif  
                            </div>
                        </div>
                    </div>
        @if ($i % 6 == 0 || $i == $total)
                </div>
            </div>
        @endif
        @php $i++; @endphp
    @endforeach
    
    @if ($total >= 6)
        <div class="col-12 text-center mt-3">
            <button class="btn theme-button {{$grid_id}}-lebih-banyak" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse_{{$grid_id}}_1">
                Lihat Lebih Banyak
            </button>
        </div>
    @endif
</div>

<style>
    .card-image {
        height: 250px; 
        overflow: hidden;
    }

    .{{ $grid_id }}_grid > .card {
        transition: 0.3s ease;
    }

    .{{ $grid_id }}_grid > .card:hover {
        background: #f15a25 !important;
        color: white !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bsTargetTotal = {{ (int) ($total / 6) }};
        const button = document.querySelector('.{{$grid_id}}-lebih-banyak');
        let bsTarget = 1;

        button.addEventListener('click', () => {
            button.dataset.bsTarget = `#collapse_{{$grid_id}}_${++bsTarget}`;
            
            if (bsTarget >= bsTargetTotal) {
                button.style.display = 'none';
            }
        });
    });
</script>