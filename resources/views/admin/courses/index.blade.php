@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="mt-5 w-full flex justify-end">
            <a href="{{ route('courses.create') }}"
                class="px-4 py-2 bg-[#192132] dark:bg-[#3f3f3f] text-white rounded-md hover:bg-[#848484] text-[12px]">
                + Create Course
            </a>
        </div>

        <table id="example" class="display dark:text-[#d6d6d6] mt-6 w-full">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Thumbnail</th> --}}
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        {{-- Thumbnail --}}
                        {{-- <td>
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail"
                                    class="w-12 h-12 object-cover rounded-md">
                            @else
                                <span class="text-gray-400 text-sm italic">No image</span>
                            @endif
                        </td> --}}

                        <td>{{ $course->title }}</td>

                        {{-- Shortened description --}}
                        <td>{{ Str::limit($course->description, 60) }}</td>

                        <td>{{ $course->creator->name ?? 'Unknown' }}</td>
                        <td>{{ $course->created_at->format('d M Y') }}</td>

                        {{-- Actions --}}
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('courses.edit', $course->id) }}" class="text-blue-400">
                                    <i class="fa-solid fa-pen cursor-pointer"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this course?')">
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
            });
        </script>
    @endpush
@endsection
