<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ config('app.dark_mode') ? 'dark' : '' }}">
<head>
    @include('partials.head')
    @livewireStyles
    <wireui:styles />
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    {{-- Dialog global --}}
    <x-dialog z-index="z-50"  align="center" width="w-md"/>
    
    {{-- Notifications global --}}
    <x-notifications />

    {{-- Topbar --}}
    <x-layouts.topbar />

    {{-- Navbar --}}
    <x-layouts.navbar />

    {{-- Main content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Scripts --}}
    <wireui:scripts />
    @fluxScripts
    @livewireScripts
</body>
</html>
