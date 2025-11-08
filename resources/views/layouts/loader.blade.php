  <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-[#D9D9D9] dark:bg-[#192132]">
        <div class="relative w-32 h-32 text-[#002D5A]" aria-label="Loading" role="status">
            <div
                class="absolute inset-0 rounded-full blur-md opacity-20 bg-linear-to-tr from-[#002D5A] via-[#0892A5] to-[#C9910D]">
            </div>
            <svg viewBox="0 0 120 120" class="relative w-full h-full">
                <g class="origin-center animate-[spin_8s_linear_infinite]">
                    <circle cx="60" cy="60" r="54" class="fill-none" stroke="currentColor"
                        stroke-width="3" opacity="0.25"></circle>
                    <g stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.6">
                        <g class="origin-center">
                            <line x1="60" y1="6" x2="60" y2="12"></line>
                            <line x1="60" y1="108" x2="60" y2="114"></line>
                            <line x1="6" y1="60" x2="12" y2="60"></line>
                            <line x1="108" y1="60" x2="114" y2="60"></line>
                        </g>
                    </g>
                </g>

                <g class="origin-center animate-[spin_5s_linear_infinite_reverse]">
                    <polygon points="60,22 66,60 60,98 54,60" fill="#C9910D" opacity="0.95"></polygon>
                    <polygon points="22,60 60,66 98,60 60,54" fill="#0892A5" opacity="0.9"></polygon>
                    <circle cx="60" cy="60" r="6" fill="white" stroke="currentColor" stroke-width="2">
                    </circle>
                </g>

                <g class="origin-center animate-[bounce_1.5s_ease-in-out_infinite]">
                    <line x1="60" y1="60" x2="60" y2="18" stroke="#C9910D" stroke-width="3"
                        stroke-linecap="round"></line>
                    <circle cx="60" cy="18" r="4" fill="#C9910D"></circle>
                </g>
            </svg>
            <p class="text-center mt-3 text-2xl font-black font-balo text-gray-600 dark:text-[#d6d6d6]">Loading...</p>
        </div>
    </div>