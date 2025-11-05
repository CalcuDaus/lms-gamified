<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
    <meta name="author" content="{{ env('APP_AUTHOR') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="flex font-['poppins'] box-border bg-[#D9D9D9] dark:bg-[#192132]">
    <aside class="flex flex-col w-20 h-dvh ">
        <div class="absolute top-4 left-4">
            <img src="{{ asset('assets/img/logo-project.png') }}" width="44px" alt="">
        </div>
        <nav class="h-full flex justify-center items-center">

            <ul class="flex flex-col gap-5 text-2xl ">
                <style>
                    @layer components {
                        .nav-item {
                            color: var(--color-main);
                        }
                        .nav-item:hover {
                            background-color: var(--color-main);
                            color: white;
                            box-shadow: 0 5px 0 var(--color-shadow);
                            transform: translateY(-2px);
                        }
                        .nav-item.active {
                            background-color: var(--color-main);
                            color: white;
                            box-shadow: 0 5px 0 var(--color-shadow);
                        }
                    }
                </style>
                <li data-tippy-content="Dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5  "
                    style="--color-main:#01ff70; --color-shadow:#00aa49;"><a href="{{ route('dashboard') }}"><i
                            class="fa-solid fa-igloo"></i></a></li>
                <li data-tippy-content="Courses" class="nav-item transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5" style="--color-main:#0074d9; --color-shadow:#005eb0;">
                    <a href=""><i class="fa-solid fa-book-open"></i></a></li>
                <li data-tippy-content="Leaderboards" class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff4136; --color-shadow:#c32d25;"><a href=""><i
                            class="fa-solid fa-trophy"></i></a></li>
                <li data-tippy-content="Badges" class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5" style="--color-main:#ff7921; --color-shadow:#b85818;">
                    <a href=""><i class="fa-solid fa-award"></i></a></li>
                <li data-tippy-content="Settings" class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#848484; --color-shadow:#3f3f3f;"><a href=""><i
                            class="fa-solid fa-gears"></i></a></li>
            </ul>
        </nav>
        <div class="absolute bottom-4 left-4">
            <a href="{{ route('auth.logout') }}"
                class="dark:text-[#d6d6d6] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-right-from-bracket text-xl"></i></a>
        </div>
    </aside>
    <main class="flex-1">
        <header class="h-16 p-4 flex items-center gap-3 text-xl text-[#192132] justify-end dark:text-zinc-100">
            <button id="theme-toggle"
                class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-moon text-xl"></i> <span class="mt-px">Swtich Theme</span> </button>
            <button class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-bell text-xl"></i></button>
        </header>
        <div class="p-7">
            @yield('content')
        </div>
    </main>
    {{-- Custom JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let theme = localStorage.getItem('theme');
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    theme: theme,
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    theme: theme,
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
    <script src="{{ asset('assets/js/theme-animation.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
