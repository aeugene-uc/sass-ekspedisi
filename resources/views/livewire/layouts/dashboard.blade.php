<!DOCTYPE html>
<html lang="en" data-theme="mytheme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col w-screen h-screen overflow-hidden">
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
                    <div class="bg-neutral min-h-full w-80 flex flex-col">
                        <h1 class="text-white text-xl p-4">Navigasi</h1>
                        <ul class="menu menu-lg w-full">
                            @foreach ($links as $name => $url)
                                <li>
                                    <a
                                        wire:navigate
                                        href="{{ $url }}"
                                        class="hover:bg-(--color-nav-active) hover:text-primary {{ request()->url() === $url ? 'bg-(--color-nav-active) text-primary' : 'text-secondary' }}"
                                    >
                                        {{ $name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-auto">
        {{-- Sidebar md --}}
        <div class="w-64 h-full bg-neutral hidden sm:flex">
            <ul class="menu menu-lg w-full">
                @foreach ($links as $name => $url)
                    <li>
                        <a
                            wire:navigate
                            href="{{ $url }}"
                            class="hover:bg-(--color-nav-active) hover:text-primary {{ request()->url() === $url ? 'bg-(--color-nav-active) text-primary' : 'text-secondary' }}"
                        >
                            {{ $name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex-1 flex flex-col bg-base-100">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>