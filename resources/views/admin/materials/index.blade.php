@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">

    <div class="mt-5 w-full flex justify-end">
        <a href="{{ route('materials.create') }}"
            class="px-4 py-2 bg-[#192132] text-white rounded-md hover:bg-[#848484] text-[12px]">
            + Create Material
        </a>
    </div>

    <table id="example" class="display dark:text-[#d6d6d6] mt-6 w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Course</th>
                <th>Title</th>
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
                <td>{{ $material->xp_reward }}</td>
                <td>
                    @if ($material->file)
                        <a href="{{ asset('storage/'.$material->file) }}" target="_blank"
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
            layout: { bottomEnd: { paging: { firstLast: false } } }
        });
    });
</script>
@endpush
@endsection
