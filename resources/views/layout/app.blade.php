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
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body class="flex font-['poppins'] box-border bg-[#D9D9D9] dark:bg-[#192132]">
    <aside class="flex flex-col w-20 h-dvh ">
        <div class="absolute top-4 left-4">
            <img src="{{ asset('assets/img/logo-project.png') }}" width="44px" alt="">
        </div>
        <nav class="h-full flex justify-center items-center">
            <ul
                class="flex flex-col gap-5 text-2xl bg-linear-to-r from-indigo-800 to-indigo-400 bg-clip-text text-transparent">
                <li data-tippy-content="Dashboard"
                    class="hover:bg-indigo-300 hover:text-indigo-800  transition-all duration-300 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-igloo"></i></a></li>
                <li data-tippy-content="Courses"
                    class="hover:bg-indigo-300 hover:text-indigo-800 transition-all duration-300 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-book-open"></i></a></li>
                <li data-tippy-content="Leaderboards"
                    class="hover:bg-indigo-300 hover:text-indigo-800 transition-all duration-300 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-trophy"></i></a></li>
                <li data-tippy-content="Badges"
                    class="hover:bg-indigo-300 hover:text-indigo-800 transition-all duration-300 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-award"></i></a></li>
                <li data-tippy-content="Settings"
                    class="hover:bg-indigo-300 hover:text-indigo-800 transition-all duration-300 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-gears"></i></a></li>
            </ul>
        </nav>
        <div class="absolute bottom-4 left-4">
            <a href="{{ route('auth.logout') }}" class="hover:bg-zinc-200 dark:hover:bg-[#192132] d px-3 py-2 rounded-full flex align-center"><i
                    class="fa-solid fa-right-from-bracket text-xl"></i></a>
        </div>
    </aside>
    <main class="flex-1">
        <header class="h-16 p-4 flex items-center gap-3 text-xl text-[#192132] justify-end dark:text-zinc-100">
            <button id="theme-toggle"
                class="text-[12px] cursor-pointer transition-all duration-300 hover:bg-zinc-200  dark:hover:bg-[#192132]  px-3 py-2 rounded-xl flex align-center"><i
                    class="fa-solid fa-moon text-xl"></i> <span class="mt-px">Swtich Theme</span> </button>
            <button class=" hover:bg-zinc-200 dark:hover:bg-[#192132] d px-3 py-2 rounded-full flex align-center"><i
                    class="fa-solid fa-bell text-xl"></i></button>
        </header>
        @yield('content')
    </main>
    <script src="{{ asset('assets/js/theme-animation.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
