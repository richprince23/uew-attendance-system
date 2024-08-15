<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('headers')
    @yield('styles')
    @vite('resources/sass/app.scss')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <livewire:scripts />
    <livewire:styles />

    <title> @yield('title')</title>
</head>

<body>
    {{-- <div class="h-full p-8 tb:p-12 md:p-16 border-2 border-red-500"> --}}
    <div class="h-full ">
        @yield('content')
    </div>
    @yield('scripts')
</body>

</html>
