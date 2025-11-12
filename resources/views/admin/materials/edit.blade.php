@extends('layouts.app')

@section('content')
<div class="max-w-[700px] mx-auto font-balo text-[#d6d6d6] mt-8">
    <h1 class="text-2xl mb-5 font-semibold">Edit Material</h1>

    <form action="{{ route('materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 text-sm">Course</label>
            <select name="course_id" class="w-full p-2 rounded bg-[#192132] text-white">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $material->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm">Title</label>
            <input type="text" name="title" value="{{ $material->title }}"
                class="w-full p-2 rounded bg-[#192132] text-white" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">Content</label>
            <textarea name="content" rows="5" class="w-full p-2 rounded bg-[#192132] text-white">{{ $material->content }}</textarea>
        </div>

        <div>
            <label class="block mb-1 text-sm">XP Reward</label>
            <input type="number" name="xp_reward" value="{{ $material->xp_reward }}"
                class="w-full p-2 rounded bg-[#192132] text-white">
        </div>

        <div>
            <label class="block mb-1 text-sm">File (optional)</label>
            @if ($material->file)
                <p class="text-sm mb-2">
                    Current: <a href="{{ asset('storage/'.$material->file) }}" target="_blank"
                        class="text-blue-400 hover:underline">View File</a>
                </p>
            @endif
            <input type="file" name="file" class="w-full p-2 rounded bg-[#192132] text-white">
        </div>

        <button type="submit"
            class="px-4 py-2 bg-[#192132] text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
            Update Material
        </button>
    </form>
</div>
@endsection
