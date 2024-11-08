<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title> {{ config('app.name', '') }} -  @yield('title', 'Meeting')</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
    @filamentStyles
    @vite(['resources/css/package.css'])

</head>

<body>

<main class="mt-24">
    @yield('content')
</main>

@livewireScripts
@filamentScripts
@vite('resources/js/package.js')
</body>

</html>
