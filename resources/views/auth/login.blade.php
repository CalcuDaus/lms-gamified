<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.login_page') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div
        class="bg-gray-800 text-gray-700 w-dvw h-dvh overflow-y-auto font-[poppins] flex justify-center items-center p-5">
        <div class="flex bg-[#EEEEEE] w-full h-full justify-center items-center rounded-lg px-2 shadow-lg">
            {{-- Login Form --}}
            <div
                class="w-[750px] h-[450px] flex justify-center items-center border-2 border-gray-300 shadow-[0_5px_0_var(--color-gray-300)] rounded-2xl">
                {{-- Left Side --}}
                <div class="lg:w-[40%] hidden h-full lg:flex justify-center items-center border-r-2 border-gray-300">
                    {{-- <img src="{{ asset('voc-market/dist/image/voc-market-logo-login.png') }}" alt=""> --}}
                </div>
                {{-- Right Side --}}
                <div class="lg:w-[60%] w-full h-full flex flex-col px-10 justify-center items-center">
                    {{-- <img src="{{ asset('voc-market/dist/image/voc-market-logo-mobile.png') }}" alt=""
                    class="w-[300px] mb-5 block lg:hidden"> --}}
                    <h2><span class="text-[#01ff70]">{{ __('messages.wel') }}</span><span class="text-[#0074d9]">{{ __('messages.come') }}</span>, <span
                            class="text-[#ff7921]">{{ __('messages.wari') }}</span><span class="text-[#ff4136]">{{ __('messages.orrs') }}</span></h2>
                    <form action="{{ route('login.post') }}" class="flex flex-col gap-4 w-full" method="POST">
                        @csrf
                        <div class="flex flex-col">
                            <label for="email" class="text-gray-700">{{ __('messages.email') }}</label>
                            <input type="email" id="email" name="email" autocomplete="off"
                                class="p-2 border-2 focus:outline-none shadow-[0_3px_0_var(--color-gray-300)] border-gray-300  rounded-md"
                                required>
                        </div>
                        <div class="flex flex-col">
                            <label for="password" class="text-gray-700">{{ __('messages.password') }}</label>
                            <input type="password" id="password" name="password"
                                class="p-2 border-2 focus:outline-none border-gray-300 shadow-[0_3px_0_var(--color-gray-300)] rounded-md"
                                required>
                        </div>
                        <button type="submit"
                            class="bg-blue-500 shadow-[0_5px_0_var(--color-blue-700)] active:shadow-none active:translate-y-0.5 text-white p-2 rounded-md ">{{ __('messages.login_button') }}</button>
                        <p class="text-gray-500 text-sm">{{ __('messages.no_account_yet') }} <a href="{{ route('register') }}"
                                class="text-blue-500">{{ __('messages.register_link') }}</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Container --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>

</html>
