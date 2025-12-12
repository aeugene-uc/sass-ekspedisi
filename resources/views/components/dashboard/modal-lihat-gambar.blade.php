@props([
    'isOpen' => false, 
    'src'
])

<div class="modal {{ $isOpen ? 'modal-open' : '' }}">
    <div class="modal-box w-96 max-w-[90vw] flex flex-col gap-2">
        <div class="flex w-full justify-between items-center">
            <h3 class="text-lg font-bold">Lihat Gambar</h3>
            <button class="cursor-pointer" type="button" wire:click="closeModal">
                <i class="fa fa-close"></i>
            </button>
        </div>

        <image src="{{ $src }}" alt="Gambar" class="w-full h-auto rounded">
    </div>
</div>