@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">

        <div class="mt-5 w-full flex justify-end">
            <a href="{{ route('materials.create') }}"
                class="px-4 py-2 bg-[#192132] dark:bg-[#3f3f3f] text-white rounded-md hover:bg-[#848484] text-[12px]">
                + Create Material
            </a>
        </div>

        <table id="example" class="display dark:text-[#d6d6d6] mt-6 w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Quiz</th>
                    <th>XP Reward</th>
                    <th>File</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->course->title ?? 'Unknown' }}</td>
                        <td>{{ $material->title }}</td>
                        <td> <div class="flex gap-2">
                            @if ($material->quizzes->count() > 0)
                            <a href="{{ route('quizzes.show', $material->quizzes[0]->id) }}" 
                                class="text-[#d1d1d1] flex items-center justify-center gap-1 text-[10px] rounded-md dark:text-[#d6d6d6] dark:bg-indigo-600 px-3 py-1 bg-[#192132]">
                                <i class="fa-solid fa-eye text-[8px]"></i><span class="mt-1">View</span>
                            </a>
                            @else
                                <a href="#" id="createQuiz" data-material-id="{{ $material->id }}"
                                class="text-[#d1d1d1] flex items-center justify-center gap-1 text-[10px] rounded-md dark:text-[#d6d6d6] dark:bg-indigo-600 px-3 py-1 bg-[#192132]">
                                <i class="fa-solid fa-plus text-[8px]"></i><span class="mt-1">Quiz</span>
                            </a>
                            @endif
                        </div>
                        </td>
                        <td>{{ $material->xp_reward }}</td>
                        <td>
                            @if ($material->file)
                                <a href="{{ asset('storage/' . $material->file) }}" target="_blank"
                                    class="text-blue-400 hover:underline">View File</a>
                            @else
                                <span class="text-gray-400 italic text-sm">No File</span>
                            @endif
                        </td>
                        <td>{{ $material->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('materials.edit', $material->id) }}" class="text-blue-400">
                                    <i class="fa-solid fa-pen cursor-pointer"></i>
                                </a>
                                <form action="{{ route('materials.destroy', $material->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this material?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="fa-solid fa-trash cursor-pointer text-red-500"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new DataTable('#example', {
                    layout: {
                        bottomEnd: {
                            paging: {
                                firstLast: false
                            }
                        }
                    }
                });
                const btnAddQuizzes = document.querySelectorAll('#createQuiz');
                btnAddQuizzes.forEach(btnAddQuiz => {
                    btnAddQuiz.addEventListener('click',  function() {
                        const {
                            value: formValues
                        } = Swal.fire({
                            title: "Multiple inputs",
                            html: `
   <form action="{{ route('quizzes.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <div>
           <input type="hidden" name="material_id" value="${Number(this.dataset.materialId)}">
        </div>
        <div>
            <label class="block mb-1 text-sm">Title</label>
            <input type="text" name="title" class="w-full p-2 rounded bg-[#192132] text-white"
                placeholder="Quiz title" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">XP Reward</label>
            <input type="number" name="xp_reward" value="0" class="w-full p-2 rounded bg-[#192132] text-white">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 text-sm">Time Limit (minutes)</label>
                <input type="number" name="time_limit" value="30" class="w-full p-2 rounded bg-[#192132] text-white">
            </div>

            <div>
                <label class="block mb-1 text-sm">Passing Score (%)</label>
                <input type="number" name="passing_score" value="70" class="w-full p-2 rounded bg-[#192132] text-white">
            </div>
        </div>

        <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
            Save Quiz
        </button>
    </form>
  `,
                            focusConfirm: false,
                            showCloseButton: true,
                            showLoaderOnConfirm: true,
                            showConfirmButton: false,
                        });
                    })
                });
            });
        </script>
    @endpush
@endsection
