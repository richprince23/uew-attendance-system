<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('styles')
    @vite('resources/sass/app.scss')
    <livewire:scripts />
    <livewire:styles />

    <title>UEW Attendance | @yield('title')</title>
</head>
{{-- <body class="bg-[url('/images/auth_bg.jpg')] "> --}}

<body>
    <style>
        body {
            background-image: url('/images/auth_bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
    {{-- <div class="flex justify-center items-center h-full"> --}}
    <div class="h-screen p-8 md:p-32 place-content-center">
        @yield('content')
    </div>
    @yield('scripts')
</body>

</html>
