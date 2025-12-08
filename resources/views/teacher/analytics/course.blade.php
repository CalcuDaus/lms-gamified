@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1400px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $title }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $course->description }}</p>
            </div>
            <a href="{{ route('teacher.courses.index') }}" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back to Courses
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full mb-8">
            {{-- Total Students --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-users text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Enrolled Students</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $enrolledStudents->count() }}</p>
            </div>

            {{-- Total Quizzes --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-clipboard-question text-4xl text-purple-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Total Quizzes</h3>
                @php
                    $totalQuizzes = $course->material->sum(fn($m) => $m->quizzes->count());
                @endphp
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $totalQuizzes }}</p>
            </div>

            {{-- Total Attempts --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-chart-line text-4xl text-green-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Quiz Attempts</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ $totalAttempts->count() }}</p>
            </div>

            {{-- Average Score --}}
            <div class="flex flex-col text-gray-600 dark:text-[#9b9b9b] hover:dark:text-[#d6d6d6] transition-all duration-300 shadow-custom rounded-3xl p-6"
                 style="--color-shadow:#9b9b9b;">
                <div class="flex items-center justify-between mb-4">
                    <i class="fa-solid fa-star text-4xl text-orange-600"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Average Score</h3>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ round($averageScore) }}%</p>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full mb-8">
            {{-- Quiz Performance Chart --}}
            <div class="shadow-custom rounded-3xl p-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Quiz Performance</h3>
                <div id="quizPerformanceChart"></div>
            </div>

            {{-- Pass/Fail Rate Chart --}}
            <div class="shadow-custom rounded-3xl p-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Pass/Fail Distribution</h3>
                <div id="passFailChart"></div>
            </div>
        </div>

        {{-- Score Distribution Chart --}}
        <div class="shadow-custom rounded-3xl p-6 w-full mb-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Score Distribution</h3>
            <div id="scoreDistributionChart"></div>
        </div>

        {{-- Student Progress Table --}}
        <div class="shadow-custom rounded-3xl p-6 w-full">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Student Progress</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 text-gray-900 dark:text-white font-semibold">Student Name</th>
                            <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Quizzes Taken</th>
                            <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Passed</th>
                            <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Average Score</th>
                            <th class="text-center py-3 px-4 text-gray-900 dark:text-white font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrolledStudents as $enrollment)
                            @php
                                $studentAttempts = $totalAttempts->where('user_id', $enrollment->user_id);
                                $passedCount = $studentAttempts->where('passed', true)->count();
                                $avgScore = $studentAttempts->avg('score') ?? 0;
                            @endphp
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($enrollment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $enrollment->user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $enrollment->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-4 px-4 text-gray-900 dark:text-white">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full font-semibold">
                                        {{ $studentAttempts->count() }}
                                    </span>
                                </td>
                                <td class="text-center py-4 px-4 text-gray-900 dark:text-white">
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full font-semibold">
                                        {{ $passedCount }}
                                    </span>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">{{ round($avgScore) }}%</span>
                                        @if($avgScore >= 80)
                                            <i class="fa-solid fa-star text-yellow-500"></i>
                                        @elseif($avgScore >= 70)
                                            <i class="fa-solid fa-thumbs-up text-green-500"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center py-4 px-4">
                                    <a href="{{ route('teacher.analytics.student', $enrollment->user_id) }}" 
                                       class="px-4 py-2 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all inline-block">
                                        <i class="fa-solid fa-eye mr-1"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    No students enrolled yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ApexCharts CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Prepare data for charts
        @php
            // Get all quizzes in this course
            $quizzes = $course->material->flatMap(function($material) {
                return $material->quizzes;
            });

            // Quiz performance data
            $quizPerformanceData = [];
            $quizLabels = [];
            foreach($quizzes as $quiz) {
                $quizAttempts = $totalAttempts->where('quiz_id', $quiz->id);
                $quizLabels[] = Str::limit($quiz->title, 20);
                $quizPerformanceData[] = $quizAttempts->count();
            }

            // Pass/Fail data
            $passedCount = $totalAttempts->where('passed', true)->count();
            $failedCount = $totalAttempts->where('passed', false)->count();

            // Score distribution
            $scoreRanges = [
                '90-100' => $totalAttempts->whereBetween('score', [90, 100])->count(),
                '80-89' => $totalAttempts->whereBetween('score', [80, 89])->count(),
                '70-79' => $totalAttempts->whereBetween('score', [70, 79])->count(),
                '60-69' => $totalAttempts->whereBetween('score', [60, 69])->count(),
                'Below 60' => $totalAttempts->where('score', '<', 60)->count(),
            ];
        @endphp

        // Quiz Performance Chart
        var quizPerformanceOptions = {
            series: [{
                name: 'Attempts',
                data: {!! json_encode(array_values($quizPerformanceData)) !!}
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                },
                background: 'transparent'
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    distributed: true,
                    horizontal: false,
                }
            },
            colors: ['#3B82F6', '#8B5CF6', '#EC4899', '#10B981', '#F59E0B', '#EF4444'],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: {!! json_encode($quizLabels) !!},
                labels: {
                    style: {
                        colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                    }
                }
            },
            grid: {
                borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB',
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            }
        };
        var quizPerformanceChart = new ApexCharts(document.querySelector("#quizPerformanceChart"), quizPerformanceOptions);
        quizPerformanceChart.render();

        // Pass/Fail Pie Chart
        var passFailOptions = {
            series: [{{ $passedCount }}, {{ $failedCount }}],
            chart: {
                type: 'donut',
                height: 350,
                background: 'transparent'
            },
            labels: ['Passed', 'Failed'],
            colors: ['#10B981', '#EF4444'],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Attempts',
                                fontSize: '16px',
                                fontWeight: 'bold',
                                color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#1F2937',
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            }
        };
        var passFailChart = new ApexCharts(document.querySelector("#passFailChart"), passFailOptions);
        passFailChart.render();

        // Score Distribution Chart
        var scoreDistributionOptions = {
            series: [{
                name: 'Number of Attempts',
                data: {!! json_encode(array_values($scoreRanges)) !!}
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                },
                background: 'transparent'
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    horizontal: true,
                    distributed: false,
                }
            },
            colors: ['#8B5CF6'],
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: {!! json_encode(array_keys($scoreRanges)) !!},
                labels: {
                    style: {
                        colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#4B5563',
                    }
                }
            },
            grid: {
                borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB',
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            }
        };
        var scoreDistributionChart = new ApexCharts(document.querySelector("#scoreDistributionChart"), scoreDistributionOptions);
        scoreDistributionChart.render();
    </script>
@endsection
