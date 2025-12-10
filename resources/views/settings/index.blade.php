@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[800px] flex-col mx-auto p-4">
        {{-- Header --}}
        <section class="w-full mb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                <i class="fa-solid fa-gears mr-2"></i>{{ __('messages.settings') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">{{ __('messages.manage_your_account') }}</p>
        </section>

        {{-- Profile Card --}}
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-user mr-2"></i>{{ __('messages.profile') }}
            </h2>
            
            <div class="flex flex-col md:flex-row items-center gap-6">
                {{-- Profile Photo --}}
                <div class="shrink-0">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                             alt="{{ $user->name }}" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-purple-500 shadow-lg"
                             loading="lazy">
                    @else
                        <div class="w-24 h-24 rounded-full bg-linear-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                {{-- User Info --}}
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-4 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm font-semibold capitalize">
                        {{ $user->role ?? 'User' }}
                    </span>
                </div>
                
                {{-- Stats (for students) --}}
                @role('student')
                <div class="flex gap-4 text-center">
                    <div class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900 rounded-xl">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.level') }}</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ $user->level ?? 1 }}</p>
                    </div>
                    <div class="px-4 py-2 bg-blue-100 dark:bg-blue-900 rounded-xl">
                        <p class="text-xs text-gray-500 dark:text-gray-400">XP</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $user->xp ?? 0 }}</p>
                    </div>
                </div>
                @endrole
            </div>
        </section>

        {{-- Earned Badges (for students) --}}
        @role('student')
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-award mr-2"></i>{{ __('messages.earned_badges') }}
            </h2>
            
            @if($user->badges->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($user->badges as $badge)
                        <div class="flex flex-col items-center p-4 bg-linear-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-yellow-200 dark:border-yellow-700 hover:shadow-lg transition-all">
                            <span class="text-4xl mb-2">{{ $badge->icon }}</span>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm text-center">{{ $badge->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-1">{{ $badge->description }}</p>
                            <span class="mt-2 px-2 py-1 bg-yellow-200 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300 rounded-full text-xs font-semibold">
                                {{ $badge->min_xp }} XP
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-medal text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_badges_yet') }}</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">{{ __('messages.earn_xp_for_badges') }}</p>
                </div>
            @endif
        </section>
        @endrole

        {{-- Account Settings --}}
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-user-pen mr-2"></i>{{ __('messages.account_settings') }}
            </h2>
            
            {{-- Update Profile Form --}}
            <form action="{{ route('settings.profile') }}" method="POST" class="mb-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.name') }}
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" 
                        class="px-6 py-3 bg-purple-500 text-white rounded-xl font-semibold hover:bg-purple-600 transition-all">
                        <i class="fa-solid fa-save mr-2"></i>{{ __('messages.update_profile') }}
                    </button>
                </div>
            </form>

            <hr class="border-gray-200 dark:border-gray-700 my-6">

            {{-- Change Password Form --}}
            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-lock mr-2"></i>{{ __('messages.change_password') }}
            </h3>
            <form action="{{ route('settings.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.current_password') }}
                        </label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('current_password') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.new_password') }}
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 rounded-xl border bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('password') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('messages.confirm_password') }}
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-xl font-semibold hover:bg-blue-600 transition-all">
                        <i class="fa-solid fa-key mr-2"></i>{{ __('messages.update_password') }}
                    </button>
                </div>
            </form>
        </section>

        {{-- Preferences --}}
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-sliders mr-2"></i>{{ __('messages.preferences') }}
            </h2>
            
            <div class="space-y-4">
                {{-- Language --}}
                <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-globe text-xl text-blue-500"></i>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ __('messages.language') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'en' ? 'English' : 'Indonesia' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('language.switch') }}" method="POST" class="flex gap-2">
                        @csrf
                        <button type="submit" name="locale" value="en" 
                                class="px-3 py-1 rounded-lg text-sm font-semibold transition-all {{ app()->getLocale() == 'en' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                            EN
                        </button>
                        <button type="submit" name="locale" value="id" 
                                class="px-3 py-1 rounded-lg text-sm font-semibold transition-all {{ app()->getLocale() == 'id' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                            ID
                        </button>
                    </form>
                </div>
                
                {{-- Theme --}}
                <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-800 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-moon text-xl text-purple-500"></i>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ __('messages.theme') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.dark_light_mode') }}</p>
                        </div>
                    </div>
                    <button id="settings-theme-toggle" 
                            class="px-4 py-2 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition-all">
                        <i class="fa-solid fa-circle-half-stroke mr-1"></i>
                        <span id="theme-label">{{ __('messages.toggle') }}</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- Logout --}}
        <section class="w-full">
            <a href="{{ route('logout') }}" 
               class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-linear-to-r from-red-500 to-red-600 text-white rounded-2xl font-bold text-lg hover:shadow-xl transition-all">
                <i class="fa-solid fa-right-from-bracket text-xl"></i>
                {{ __('messages.logout') }}
            </a>
        </section>
    </div>

    @push('scripts')
    <script>
        document.getElementById('settings-theme-toggle').addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    </script>
    @endpush
@endsection
