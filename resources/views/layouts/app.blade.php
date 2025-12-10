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
    {{-- Data Tables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css">
    {{-- Alpine.js for interactive components --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body class="flex font-['poppins'] box-border bg-[#D9D9D9] dark:bg-[#192132]">
    {{-- Loader --}}
    @include('layouts.loader')
    @include('layouts.sidebar')
    <main class="flex-1">
        <header class="h-16 p-4 flex items-center gap-3 text-xl text-[#192132] justify-end dark:text-zinc-100">
            {{-- Language Switcher --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6] active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white dark:hover:bg-[#ffffff] dark:hover:text-[#192132] px-3 py-2 rounded-md flex items-center gap-2">
                    <i class="fa-solid fa-language text-xl"></i>
                    <span class="mt-px">{{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}</span>
                </button>
            
                {{-- Dropdown Menu --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-40 translate-x-10 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50"
                    style="display: none;">
                    <form action="{{ route('language.switch') }}" method="POST">
                        @csrf
                        <button type="submit" name="locale" value="en"
                            class="w-full px-4 py-3 text-left hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-3 transition-colors {{ app()->getLocale() == 'en' ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <span class="text-[12px]">EN</span>
                            <span class="text-gray-900 dark:text-white  text-[12px] font-semibold">English</span>
                        </button>
                        <button type="submit" name="locale" value="id"
                            class="w-full px-4 py-3 text-left hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-3 transition-colors {{ app()->getLocale() == 'id' ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <span class="text-[12px]">ID</span>
                            <span class="text-gray-900 dark:text-white  text-[12px] font-semibold">Indonesia</span>
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Theme Toggle --}}
            <button id="theme-toggle"
                class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-moon text-xl"></i> <span class="mt-px">Swtich Theme</span> </button>
            {{-- Notifications --}}
            <button
                class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-bell text-xl"></i></button>
        </header>
        <div class="p-7 ms-0 md:ms-20 mb-20 md:mb-0">
            @yield('content')
        </div>
        {{-- Bottom Navigation for Mobile --}}
        @role('student')
        <nav
            class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-[#192132] border-t border-gray-200 dark:border-gray-700 z-50 shadow-lg">
            <ul class="flex justify-around items-center py-2">
                <li>
                    <a href="{{ route('student.dashboard') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('student/dashboard') ? 'text-[#01ff70]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-igloo text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.courses') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('courses/*') || request()->is('courses') ? 'text-[#0074d9]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-book-open text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.courses') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.leaderboard') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('leaderboard') ? 'text-[#ff4136]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-trophy text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.leaderboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('settings') ? 'text-[#848484]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-gears text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.settings') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endrole
        
        {{-- Teacher Bottom Navigation for Mobile --}}
        @role('teacher')
        <nav
            class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-[#192132] border-t border-gray-200 dark:border-gray-700 z-50 shadow-lg">
            <ul class="flex justify-around items-center py-2">
                <li>
                    <a href="{{ route('teacher.dashboard') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('teacher/dashboard') ? 'text-[#01ff70]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-chalkboard-user text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('teacher.courses.index') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('teacher/courses*') ? 'text-[#0074d9]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-book-open text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.my_courses') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}"
                        class="flex flex-col items-center gap-1 px-4 py-2 {{ request()->is('settings') ? 'text-[#848484]' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="fa-solid fa-gears text-xl"></i>
                        <span class="text-[10px]">{{ __('messages.settings') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endrole
    </main>
    {{-- Custom JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let theme = localStorage.getItem('theme');
            // Initialize tooltips only on desktop (md breakpoint and above)
            if (window.innerWidth >= 768) {
                tippy('[data-tippy-content]', {
                    placement: 'right',
                    animation: 'scale',
                });
            }

            // Reinitialize on window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768 && !document.querySelector('[data-tippy-root]')) {
                    tippy('[data-tippy-content]', {
                        placement: 'right',
                        animation: 'scale',
                    });
                } else if (window.innerWidth < 768) {
                    // Destroy tooltips on mobile
                    document.querySelectorAll('[data-tippy-content]').forEach(el => {
                        if (el._tippy) {
                            el._tippy.destroy();
                        }
                    });
                }
            });            
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    theme: theme,
                    text: '{{ session('success') }}',
                    timer: 2000,
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    theme: theme,
                    text: '{{ session('error') }}',
                    timer: 2000,
                });
            @endif
            window.addEventListener("load", () => {
                const loader = document.getElementById("page-loader");
                loader.classList.add("opacity-0", "transition-opacity", "duration-800");
                setTimeout(() => (loader.style.display = "none"), 800);
            });
        });
    </script>
    @stack('scripts')
    <script src="{{ asset('assets/js/theme-animation.js') }}"></script>
</body>

</html>
