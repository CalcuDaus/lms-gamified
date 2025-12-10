@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="mt-5 w-full flex justify-end">
            <a href="{{ route('badges.create') }}"
                class="px-4 py-2 bg-[#192132] dark:bg-[#3f3f3f] text-white rounded-md hover:bg-[#848484] text-[12px]">
                + Create Badge
            </a>
        </div>

        <table id="example" class="display dark:text-[#d6d6d6] mt-6 w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Min XP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($badges as $badge)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($badge->icon)
                                <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}"
                                    class="w-10 h-10 object-cover rounded-md" loading="lazy">
                            @else
                                <span class="text-gray-400 text-sm italic">No icon</span>
                            @endif
                        </td>
                        <td>{{ $badge->name }}</td>
                        <td>{{ Str::limit($badge->description, 60) }}</td>
                        <td>{{ $badge->min_xp }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('badges.edit', $badge->id) }}" class="text-blue-400">
                                    <i class="fa-solid fa-pen cursor-pointer"></i>
                                </a>
                                <form action="{{ route('badges.destroy', $badge->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this badge?')">
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
                            paging: { firstLast: false }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
