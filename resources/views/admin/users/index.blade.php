@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1000px] dark:text-[#d6d6d6] flex-col mx-auto">
        <div class="mt-5">
            <a href="{{ route('users.create') }}"
                class="px-4 py-2 bg-[#192132] dark:bg-[#3f3f3f] text-white rounded-md hover:bg-[#848484] text-[12px]">Create User</a>
        </div>
        <table id="example" class="display dark:text-[#d6d6d6] ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Level</th>
                    <th>Xp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->level }}</td>
                        <td>{{ $user->xp }}</td>
                        <td><div class="flex gap-2 ">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-400"><i class="fa-solid fa-pen cursor-pointer"></i></a>
                            <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button><i class="fa-solid fa-trash cursor-pointer text-red-500"></i></button>
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
                const table = new DataTable('#example', {
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
