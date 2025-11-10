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
    @stack('styles')
</head>

<body class="flex font-['poppins'] box-border bg-[#D9D9D9] dark:bg-[#192132]">
    {{-- Loader --}}
    @include('layouts.loader')
    @include('layouts.sidebar')
    <main class="flex-1">
        <header class="h-16 p-4 flex items-center gap-3 text-xl text-[#192132] justify-end dark:text-zinc-100">
            <button id="theme-toggle"
                class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-moon text-xl"></i> <span class="mt-px">Swtich Theme</span> </button>
            <button
                class="text-[12px] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                    class="fa-solid fa-bell text-xl"></i></button>
        </header>
        <div class="p-7 ms-20">
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
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
