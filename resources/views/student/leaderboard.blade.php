@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-4">
        {{-- Header --}}
        <section
            class="flex flex-col md:flex-row gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-4 md:p-6 mb-6"
            style="--color-shadow:#9b9b9b;">
            <div class="flex items-center gap-4">
                <i class="fa-solid fa-trophy text-5xl text-yellow-500"></i>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ __('messages.leaderboard') }}</h1>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">{{ __('messages.top_learners') }}</p>
                </div>
            </div>
            <div class="text-center bg-linear-to-r from-purple-500 to-pink-500 text-white rounded-2xl p-4">
                <p class="text-sm">{{ __('messages.your_xp') }}</p>
                <p class="text-2xl md:text-3xl font-bold">{{ $currentUser->exp ?? 0 }}</p>
            </div>
            </section>

            {{-- Leaderboard List --}}
            <section class="w-full shadow-custom rounded-3xl p-4 md:p-8 text-gray-600 dark:text-[#EEEEEE]"
                style="--color-shadow:#9b9b9b;">
                <div class="space-y-4">
                    @foreach ($topUsers as $index => $user)
                        @php
                            $rankColors = [
                                1 => 'from-yellow-400 to-yellow-600', // Gold
                                2 => 'from-gray-300 to-gray-500', // Silver
                                3 => 'from-orange-400 to-orange-600', // Bronze
                            ];
                            $isCurrentUser = $currentUser && $user->id === $currentUser->id;
                            $bgColor = $rankColors[$index + 1] ?? 'from-blue-400 to-purple-500';
                        @endphp
                        <div
                            class="flex flex-col md:flex-row items-center gap-3 md:gap-6 p-4 md:p-6 rounded-2xl {{ $isCurrentUser ? 'bg-linear-to-r from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 border-4 border-indigo-500' : 'bg-gray-100 dark:bg-gray-800' }} transition-all hover:shadow-lg">
                            <div
                                class="shrink-0 w-12 h-12 md:w-16 md:h-16 rounded-full bg-linear-to-r {{ $bgColor }} flex items-center justify-center text-white font-bold text-xl md:text-2xl shadow-lg">
                                @if ($index < 3)
                                    <i
                                        class="fa-solid fa-crown {{ $index === 0 ? 'text-yellow-300' : ($index === 1 ? 'text-gray-200' : 'text-orange-300') }}"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="text-base md:text-xl font-bold hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ $isCurrentUser ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                        {{ $user->name }}
                                    </a>
                                    @if ($isCurrentUser)
                                        <span
                                            class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full">{{ __('messages.you') }}</span>
                                    @endif
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center gap-3 md:gap-6 w-full md:w-auto justify-around md:justify-end">
                                <div class="text-center">
                                    <p class="text-gray-500 dark:text-gray-400 text-xs">{{ __('messages.level') }}</p>
                                    <p class="text-xl md:text-2xl font-bold text-purple-600 dark:text-purple-400">
                                        {{ $user->level ?? 1 }}</p>
                                </div>
                                <div
                                    class="text-center px-3 md:px-6 py-2 md:py-3 bg-linear-to-r from-yellow-400 to-orange-500 rounded-xl shadow-md">
                                    <p class="text-white text-xs font-semibold">{{ __('messages.total_xp') }}</p>
                                    <p class="text-white text-2xl md:text-3xl font-bold">{{ $user->exp ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($topUsers->count() === 0)
                        <div class="text-center py-12">
                            <i class="fa-solid fa-users-slash text-6xl text-gray-400 mb-4"></i>
                            <p class="text-xl text-gray-500 dark:text-gray-400">{{ __('messages.no_users_yet') }}</p>
                        </div>
                    @endif
            </div>
        </section>

        {{-- Back Button --}}
        <div class="mt-6">
            <a href="{{ route('student.dashboard') }}"
                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i> {{ __('messages.back_to_dashboard') }}
            </a>
        </div>
    </div>
@endsection
