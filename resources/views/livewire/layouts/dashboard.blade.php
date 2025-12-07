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
<body>
    <div class="navbar bg-neutral shadow-sm">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl text-white">{{ $title }}</a>
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
                    <h1>Navigasi</h1>
                    <ul class="menu bg-base-200 min-h-full w-80 p-4">
                        <li><a>Sidebar Item 1</a></li>
                        <li><a>Sidebar Item 2</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{ $slot }}

    @livewireScripts
</body>
</html>