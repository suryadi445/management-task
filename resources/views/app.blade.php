<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body>
        <div id="app">
            <navbar-component></navbar-component> 
            <div class="min-h-screen px-10 mt-5">
                <div class="container p-4 mx-auto border rounded-md shadow-lg">
                    <router-view></router-view>
                    {{-- <pagination :current-page="{{ $currentPage }}" :total-pages="{{ $totalPages }}"></pagination> --}}
                </div>
            </div>
            <footer-component></footer-component> 
        </div>

    </body>
</html>
