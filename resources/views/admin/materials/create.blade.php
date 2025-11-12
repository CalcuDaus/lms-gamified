@extends('layouts.app')

@section('content')
<div class="max-w-[700px] mx-auto font-balo text-[#d6d6d6] mt-8">
    <h1 class="text-2xl mb-5 font-semibold">Create Material</h1>

    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf

        <div>
            <label class="block mb-1 text-sm">Course</label>
            <select name="course_id" class="w-full p-2 rounded bg-[#192132] text-white">
                <option value="">-- Select Course --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm">Title</label>
            <input type="text" name="title" class="w-full p-2 rounded bg-[#192132] text-white"
                placeholder="Material title" required>
        </div>

        <div>
            <label class="block mb-1 text-sm">Content</label>
            <textarea name="content" rows="5" class="w-full p-2 rounded bg-[#192132] text-white"
                placeholder="Material content (optional)"></textarea>
        </div>

        <div>
            <label class="block mb-1 text-sm">XP Reward</label>
            <input type="number" name="xp_reward" class="w-full p-2 rounded bg-[#192132] text-white"
                placeholder="XP points for completing this material" value="0">
        </div>

        <div>
            <label class="block mb-1 text-sm">File (optional)</label>
            <input type="file" name="file" class="w-full p-2 rounded bg-[#192132] text-white">
        </div>

        <button type="submit"
            class="px-4 py-2 bg-[#192132] text-white rounded-md hover:bg-[#848484] text-[14px] mt-3">
            Save Material
        </button>
    </form>
</div>
@endsection
