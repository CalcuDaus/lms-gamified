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
        <div class="logo">
            <img src="{{ asset('assets/img/logo-project.png') }}" width="44px" alt="">
        </div>
        <nav class="h-full flex justify-center items-center">
            <ul
                class="flex flex-col gap-5 text-2xl bg-linear-to-r from-blue-500 to-green-500 bg-clip-text text-transparent text-">
                <li data-tippy-content="Dashboard" class="hover:bg-indigo-100 hover:text-zinc-400 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-igloo"></i></a></li>
                <li data-tippy-content="Courses" class="hover:bg-indigo-100 hover:text-zinc-400 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-book-open"></i></a></li>
                <li data-tippy-content="Leaderboards" class="hover:bg-indigo-100 hover:text-zinc-400 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-trophy"></i></a></li>
                <li data-tippy-content="Badges" class="hover:bg-indigo-100 hover:text-zinc-400 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-award"></i></a></li>
                <li data-tippy-content="Settings" class="hover:bg-indigo-100 hover:text-zinc-400 p-2 rounded-md"><a
                        href=""><i class="fa-solid fa-gears"></i></a></li>
            </ul>
        </nav>
    </aside>
    <main class="flex-1">
        <header class="h-16 p-4 flex items-center gap-3 text-xl text-zinc-500 justify-end">
            <button id="theme-toggle" class="text-[12px] hover:bg-indigo-100  px-3 py-2 rounded-xl flex align-center"><i
                    class="fa-solid fa-moon text-xl"></i> <span class="mt-px">Swtich Theme</span> </button>
            <button class=" hover:bg-indigo-100  px-3 py-2 rounded-full flex align-center"><i
                    class="fa-solid fa-bell text-xl"></i></button>
        </header>
        @yield('content')
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = document.documentElement;
            const themeToggle = document.getElementById("theme-toggle");
            const body = document.body;

            // 🌓 Fungsi untuk menerapkan tema dari localStorage
            function applyTheme(theme) {
                if (theme === "dark") {
                    html.classList.add("dark");
                } else {
                    html.classList.remove("dark");
                }
            }

            // 🌗 Cek dan terapkan tema awal
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme) {
                applyTheme(savedTheme);
            } else {
                // jika belum ada di localStorage, gunakan preferensi sistem
                const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
                applyTheme(prefersDark ? "dark" : "light");
                localStorage.setItem("theme", prefersDark ? "dark" : "light");
            }

            // ✨ Event: klik tombol toggle
            themeToggle.addEventListener("click", () => {
                const currentTheme = localStorage.getItem("theme");

                let newTheme;

                if (currentTheme === "dark") {
                    const themeAnimation = document.createElement("div");
                    themeAnimation.classList.add("theme-animation-light");
                    body.appendChild(themeAnimation);
                    newTheme = "light";
                } else {
                    const themeAnimation = document.createElement("div");
                    themeAnimation.classList.add("theme-animation-dark");
                    body.appendChild(themeAnimation);
                    newTheme = "dark";
                }

                setTimeout(() => {
                        setTimeout(() => {
                            applyTheme(newTheme);
                            document.querySelector(".theme-animation-dark")?.remove(), document.querySelector(".theme-animation-light")?.remove();
                            localStorage.setItem("theme", newTheme);
                        }, 100)
                }, 1800);
            });

            // 🔄 Update otomatis jika localStorage berubah di tab lain
            window.addEventListener("storage", (e) => {
                if (e.key === "theme") {
                    applyTheme(e.newValue);
                }
            });
        });
    </script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
