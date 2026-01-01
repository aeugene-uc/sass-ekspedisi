@php
function renderMenu($links) {
    echo '<ul class="menu menu-lg w-full">';
    foreach ($links as $name => $value) {
        if (is_array($value)) {
            echo '<li><details open><summary class="hover:bg-(--color-nav-active) hover:text-primary text-secondary">' . $name . '</summary>';
            renderMenu($value);
            echo '</details></li>';
        } else {
            $active = request()->url() === $value ? 'bg-(--color-nav-active) text-primary' : 'text-secondary';
            echo '<li><a wire:navigate href="' . $value . '" class="mb-3 hover:bg-(--color-nav-active) hover:text-primary ' . $active . '">' . $name . '</a></li>';
        }
    }
    echo '</ul>';
}
@endphp


<!DOCTYPE html>
<html lang="en" data-theme="mytheme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/maplibre-gl@3.6.1/dist/maplibre-gl.css" rel="stylesheet"/>
    <script src="https://unpkg.com/maplibre-gl@3.6.1/dist/maplibre-gl.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col w-screen h-screen overflow-hidden" x-data="{ modalLogoutVisible: false }">
    <div class="navbar bg-neutral shadow-sm">
        <div class="flex-1">
            <h1 class="text-xl text-white font-semibold p-3">{{ $title }}</h1>
        </div>
        <div class="flex-none">
            <div class="drawer drawer-end">
                <input id="sidebar" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <label 
                        class="drawer-button inline-flex p-3 cursor-pointer sm:hidden"
                        for="sidebar"
                    >
                        <i class="fa-solid fa-bars text-white text-xl"></i>
                    </label>
                </div>
                <div class="drawer-side">
                    <label for="sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="bg-neutral h-full w-80 flex flex-col">
                        <h1 class="text-white text-xl p-4">Navigasi</h1>
                        <div class="w-full h-full overflow-auto">
                            {{ renderMenu($links) }}
                        </div>
                        <div class="flex w-full p-2">
                            <button class="btn btn-primary w-full" x-on:click="modalLogoutVisible = true">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 flex overflow-hidden">
        {{-- Sidebar md --}}
        <div class="w-64 h-full bg-neutral hidden sm:flex flex-col overflow-y-auto">
            <div class="w-full h-full">
                {{ renderMenu($links) }}
            </div>
            <div class="flex w-full p-2">
                <button type="button" class="btn btn-primary w-full" x-on:click="modalLogoutVisible = true">Logout</button>
            </div>
        </div>

        <div class="flex-1 flex flex-col bg-base-100 overflow-y-auto p-8">
            {{ $slot }}
        </div>
    </div>


    <div class="modal" :class="{ 'modal-open': modalLogoutVisible }">
        <div class="modal-box w-96 max-w-[90vw]">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Logout</h3>
                <button class="cursor-pointer" type="button" x-on:click="modalLogoutVisible = false">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <p>Apa Anda yakin ingin logout?</p>

            <a class="btn btn-error w-full mt-4" href="logout" wire:navigate>Logout</a>
        </div>
    </div>


    @livewireScripts
</body>
</html>