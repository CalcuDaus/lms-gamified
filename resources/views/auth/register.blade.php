<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.register_page') }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    {{-- Main Container --}}
    <div
        class="bg-gray-800 text-gray-700 w-full h-auto lg:w-dvw lg:h-dvh font-[poppins] flex justify-center items-center lg:p-5 p-2">
        <div
            class="flex bg-[#EEEEEE] w-full h-full justify-center items-center rounded-lg px-2 py-5 shadow-lg overflow-y-auto">
            {{-- REgister Form --}}
            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data"
                class="lg:w-[1000px] text-sm lg:h-[650px] h-auto  w-full flex lg:flex-row flex-col justify-center items-center border-2 border-gray-300 shadow-[0_5px_0_var(--color-gray-300)] rounded-2xl">
                {{-- Left Side --}}
                @csrf
                <div
                    class="lg:w-1/2 w-full h-full flex lg:border-r-2 border-b-2 border-gray-300 flex-col lg:px-10 px-5 py-8 justify-center items-center">
                    <div class="flex flex-col gap-4 w-full">
                        <div class="flex flex-col">
                            <label for="name" class="text-gray-700 w-full">{{ __('messages.name') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" autocomplete="off"
                                class="p-2 border-2 focus:outline-none w-full shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label for="email" class="text-gray-700">{{ __('messages.email') }} <span
                                    class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" autocomplete="off"
                                class="p-2 border-2 focus:outline-none shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                required>
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-1 items-center">
                            <div class="w-1/2">
                                <label for="password" class="text-gray-700 w-full">{{ __('messages.password') }} <span
                                        class="text-red-500">*</span></label>
                                <input type="password" id="password" name="password" autocomplete="off"
                                    class="p-2 border-2 focus:outline-none w-full shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                    required>
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label for="password_confirmation" class="text-gray-700 w-full">{{ __('messages.confirm_password') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="off"
                                    class="p-2 border-2 focus:outline-none w-full shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                    required>
                                @error('password_confirmation')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="role">{{ __('messages.select_role_label') }} <span class="text-red-500">*</span></label>
                            <select name="role" id="role"
                                class="p-2 border-2 focus:outline-none shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                required>
                                <option value="" disabled selected>{{ __('messages.select_role') }}</option>
                                <option value="teacher">{{ __('messages.teacher') }}</option>
                                <option value="student">{{ __('messages.student') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Right Side --}}
                <div class="lg:w-1/2 w-full h-full flex flex-col lg:px-10 px-5 py-5 justify-center items-center">
                    <div class="flex flex-col gap-4 w-full">
                        <div class="flex flex-col">
                            <label for="foto_profil" class="text-gray-700">{{ __('messages.profile_photo') }} <span
                                    class="text-red-500">*</span></label>
                            <div class="flex items-center justify-center w-full h-36">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div id="preview"
                                        class="flex w-full h-full flex-col items-center justify-center ">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">{{ __('messages.click_to_upload') }}</span> {{ __('messages.or_drag_drop') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.image_format_limit') }}</p>
                                    </div>
                                    <input id="dropzone-file" name="avatar" type="file" class="hidden" />
                                </label>
                                @error('avatar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="phone" class="text-gray-700">{{ __('messages.phone_number') }}<span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="phone" name="phone"
                                class="p-2 border-2 focus:outline-none shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                required>
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-blue-500 shadow-[0_5px_0_var(--color-blue-700)] active:shadow-none active:translate-y-0.5 text-white p-2 rounded-md ">{{ __('messages.register_button') }}</button>
                        <p class="text-gray-500 text-sm">{{ __('messages.already_have_account') }} <a href="{{ route('login') }}"
                                class="text-blue-500">{{ __('messages.login_link') }}</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const dropzone = document.getElementById('dropzone-file');
        const preview = document.getElementById('preview');
        const reader = new FileReader();
        dropzone.addEventListener('change', function() {
            preview.innerHTML = '';
            reader.readAsDataURL(this.files[0]);
            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-lg');
                preview.appendChild(img);
            };
        });
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.success') }}',
                theme: 'auto',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ __('messages.error') }}',
                theme: 'auto',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>
</body>

</html>
