<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
    <meta name="author" content="{{ env('APP_AUTHOR') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="flex font-['poppins']">
    <aside class="flex flex-col w-20 h-dvh">
        <div class="logo">
            <img src="{{ asset('assets/img/logo-project.png') }}" width="44px" alt="">
        </div>
        <nav class="h-full flex justify-center items-center">
            <ul class="flex flex-col gap-7 text-2xl text-zinc-500">
                <li data-tippy-content="Dashboard"><a href=""><i class="fa-solid fa-igloo"></i></a></li>
                <li data-tippy-content="Courses"><a href=""><i class="fa-solid fa-book-open"></i></a></li>
                <li data-tippy-content="Leaderboards"><a href=""><i class="fa-solid fa-trophy"></i></a></li>
                <li data-tippy-content="Badges"><a href=""><i class="fa-solid fa-award"></i></a></li>
                <li data-tippy-content="Settings"><a href=""><i class="fa-solid fa-gears"></i></a></li>
            </ul>
        </nav>
    </aside>
    <main class="flex-1">
        <header>
            <i class="fa-solid fa-moon"></i>
        </header>
        @yield('content')
    </main>
<script src="{{ asset("assets/js/main.js") }}"></script>
</body>

</html>
