@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[800px] flex-col mx-auto p-4">
        {{-- Header with Back Button --}}
        <section class="w-full mb-6 flex items-center gap-4">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>{{ __('messages.back') }}
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    <i class="fa-solid fa-user mr-2"></i>{{ __('messages.profile_of') }} {{ $profileUser->name }}
                </h1>
            </div>
        </section>

        {{-- Profile Card --}}
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <div class="flex flex-col md:flex-row items-center gap-6">
                {{-- Profile Photo --}}
                <div class="shrink-0">
                    @if($profileUser->profile_photo)
                        <img src="{{ asset('storage/' . $profileUser->profile_photo) }}" 
                             alt="{{ $profileUser->name }}" 
                             class="w-28 h-28 rounded-full object-cover border-4 border-purple-500 shadow-lg">
                    @else
                        <div class="w-28 h-28 rounded-full bg-linear-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                            {{ strtoupper(substr($profileUser->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                {{-- User Info --}}
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $profileUser->name }}</h2>
                    <span class="inline-block mt-2 px-4 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-full text-sm font-semibold capitalize">
                        {{ $profileUser->role ?? 'User' }}
                    </span>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                        <i class="fa-solid fa-calendar-alt mr-1"></i>
                        {{ __('messages.member_since') }}: {{ $profileUser->created_at->format('M Y') }}
                    </p>
                </div>
                
                {{-- Stats --}}
                @if($profileUser->role === 'student')
                <div class="flex flex-wrap gap-3 justify-center">
                    <div class="px-4 py-3 bg-yellow-100 dark:bg-yellow-900 rounded-xl text-center min-w-[80px]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.level') }}</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ $profileUser->level ?? 1 }}</p>
                    </div>
                    <div class="px-4 py-3 bg-blue-100 dark:bg-blue-900 rounded-xl text-center min-w-[80px]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">XP</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $profileUser->xp ?? 0 }}</p>
                    </div>
                    <div class="px-4 py-3 bg-orange-100 dark:bg-orange-900 rounded-xl text-center min-w-[80px]">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.streak') }}</p>
                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-300">
                            {{ $profileUser->current_streak ?? 0 }} <i class="fa-solid fa-fire text-lg"></i>
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </section>

        {{-- Earned Badges --}}
        @if($profileUser->role === 'student')
        <section class="w-full shadow-custom rounded-3xl p-6 mb-6 text-gray-600 dark:text-[#EEEEEE]"
            style="--color-shadow:#9b9b9b;">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                <i class="fa-solid fa-award mr-2"></i>{{ __('messages.earned_badges') }}
            </h2>
            
            @if($profileUser->badges->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($profileUser->badges as $badge)
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
                </div>
            @endif
        </section>
        @endif

        {{-- Back to Leaderboard Button --}}
        <div class="w-full">
            <a href="{{ route('student.leaderboard') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-linear-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-trophy mr-2"></i>{{ __('messages.back_to_leaderboard') }}
            </a>
        </div>
    </div>
@endsection
