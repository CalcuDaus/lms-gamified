@extends('layouts.app')
@section('content')
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Admin Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Example Statistic Card -->
            <div class="bg-white dark:bg-[#2c2f48] rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Users</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">1,234</p>
            </div>
            <div class="bg-white dark:bg-[#2c2f48] rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Active Courses</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">56</p>
            </div>
            <div class="bg-white dark:bg-[#2c2f48] rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">New Enrollments</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">78</p>
            </div>
            <div class="bg-white dark:bg-[#2c2f48] rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Revenue</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">$12,345</p>
            </div>
        </div>
    </div>
@endsection
