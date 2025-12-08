<aside class="flex fixed top-0 flex-col w-20 h-dvh ">
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
            @role('student')
                <li data-tippy-content="Dashboard"
                    class="nav-item {{ request()->is('student/dashboard') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5  "
                    style="--color-main:#01ff70; --color-shadow:#00aa49;"><a href="{{ route('student.dashboard') }}"><i
                            class="fa-solid fa-igloo"></i></a></li>
                <li data-tippy-content="Courses"
                    class="nav-item {{ request()->is('courses/*') || request()->is('courses') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#0074d9; --color-shadow:#005eb0;">
                    <a href="{{ route('student.courses') }}"><i class="fa-solid fa-book-open"></i></a>
                </li>
                <li data-tippy-content="Leaderboards"
                    class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff4136; --color-shadow:#c32d25;"><a href=""><i
                            class="fa-solid fa-trophy"></i></a></li>
                <li data-tippy-content="Badges"
                    class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff7921; --color-shadow:#b85818;">
                    <a href=""><i class="fa-solid fa-award"></i></a>
                </li>
                <li data-tippy-content="Settings"
                    class="nav-item  transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#848484; --color-shadow:#3f3f3f;"><a href=""><i
                            class="fa-solid fa-gears"></i></a></li>
                @elserole('admin')
                <li data-tippy-content="Admin Dashboard"
                    class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5  "
                    style="--color-main:#01ff70; --color-shadow:#00aa49;"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa-solid fa-line-chart"></i></a></li>
                <li data-tippy-content="Users"
                    class="nav-item {{ request()->is('admin/users') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5  "
                    style="--color-main:#0074d9; --color-shadow:#005eb0;"><a href="{{ route('users.index') }}"><i
                            class="fa-solid fa-users"></i></a></li>
                <li data-tippy-content="Courses"
                    class="nav-item {{ request()->is('admin/courses') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff4136; --color-shadow:#c32d25;">
                    <a href="{{ route('courses.index') }}"><i class="fa-solid fa-book-open"></i></a>
                </li>
                <li data-tippy-content="Badges"
                    class="nav-item  {{ request()->is('admin/badges') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff7921; --color-shadow:#b85818;">
                    <a href="{{ route('badges.index') }}"><i class="fa-solid fa-award"></i></a>
                </li>
                <li data-tippy-content="Materials"
                    class="nav-item  {{ request()->is('admin/materials') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff7921; --color-shadow:#b85818;">
                    <a href="{{ route('materials.index') }}"><i class="fa-solid fa-book"></i></a>
                </li>
                @elserole('teacher')
                <li data-tippy-content="Teacher Dashboard"
                    class="nav-item {{ request()->is('teacher/dashboard') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5  "
                    style="--color-main:#01ff70; --color-shadow:#00aa49;"><a href="{{ route('teacher.dashboard') }}"><i
                            class="fa-solid fa-chalkboard-user"></i></a></li>
                <li data-tippy-content="My Courses"
                    class="nav-item {{ request()->is('teacher/courses*') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#0074d9; --color-shadow:#005eb0;">
                    <a href="{{ route('teacher.courses.index') }}"><i class="fa-solid fa-book-open"></i></a>
                </li>
                <li data-tippy-content="Analytics"
                    class="nav-item {{ request()->is('teacher/analytics*') || request()->is('teacher/students*') ? 'active' : '' }} transition-all duration-300 px-3 py-2 rounded-md active:shadow-none active:translate-y-0.5"
                    style="--color-main:#ff4136; --color-shadow:#c32d25;">
                    <a href="{{ route('teacher.courses.index') }}"><i class="fa-solid fa-chart-line"></i></a>
                </li>
            @endrole
        </ul>
    </nav>
    <div class="absolute bottom-4 left-4">
        <a href="{{ route('logout') }}"
            class="dark:text-[#d6d6d6] cursor-pointer hover:shadow-[0_5px_0_#3f3f3f] dark:hover:shadow-[0_5px_0_#d6d6d6]  active:shadow-none dark:active:shadow-none active:translate-y-0.5 transition-all duration-300 hover:bg-[#848484] hover:text-white  dark:hover:bg-[#ffffff] dark:hover:text-[#192132]  px-3 py-2 rounded-md flex align-center"><i
                class="fa-solid fa-right-from-bracket text-xl"></i></a>
    </div>
</aside>
