@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center font-balo max-w-[1200px] flex-col mx-auto p-6">
        {{-- Header --}}
        <div class="flex gap-4 justify-between w-full items-center text-gray-600 dark:text-[#EEEEEE] shadow-custom rounded-3xl p-6 mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Add Material</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $course->title }}</p>
            </div>
            <a href="{{ route('teacher.courses.edit', $course->id) }}" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i>Back
            </a>
        </div>

        {{-- Form --}}
        <div class="w-full shadow-custom rounded-3xl p-8">
            <form action="{{ route('teacher.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="title" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Material Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                           placeholder="e.g., Introduction to Laravel">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Content
                    </label>
                    <textarea name="content" id="materialContent">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="video_url" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Video URL (Optional)
                        </label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                               placeholder="https://youtube.com/watch?v=...">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">YouTube, Vimeo, or other video URL</p>
                        @error('video_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="file" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Attachment (Optional)
                        </label>
                        <input type="file" name="file" id="file"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">PDF, DOC, PPT (max 10MB)</p>
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="xp_reward" class="block text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        XP Reward <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="xp_reward" id="xp_reward" required min="0" value="{{ old('xp_reward', 50) }}"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"
                           placeholder="50">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">XP students earn when they complete this material</p>
                    @error('xp_reward')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:shadow-2xl transition-all">
                        <i class="fa-solid fa-check mr-2"></i>Add Material
                    </button>
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" 
                       class="px-8 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold text-lg hover:shadow-lg transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- EasyMDE Markdown Editor --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    
    <style>
        .EasyMDEContainer .CodeMirror {
            min-height: 300px;
            border-radius: 12px;
            border: 2px solid #d1d5db;
            background: white;
        }
        
        .dark .EasyMDEContainer .CodeMirror {
            background: #1f2937;
            border-color: #4b5563;
            color: #f3f4f6;
        }
        
        .dark .EasyMDEContainer .CodeMirror-cursor {
            border-left-color: #f3f4f6;
        }
        
        .EasyMDEContainer .editor-toolbar {
            border-radius: 12px 12px 0 0;
            border: 2px solid #d1d5db;
            border-bottom: none;
            background: #f9fafb;
        }
        
        .dark .EasyMDEContainer .editor-toolbar {
            background: #111827;
            border-color: #4b5563;
        }
        
        .dark .EasyMDEContainer .editor-toolbar a {
            color: #d1d5db !important;
        }
        
        .dark .EasyMDEContainer .editor-toolbar a:hover {
            background: #374151;
            border-color: #6b7280;
        }
        
        .dark .EasyMDEContainer .editor-preview {
            background: #1f2937;
            color: #f3f4f6;
        }
        
        .dark .EasyMDEContainer .editor-preview-side {
            background: #1f2937;
            border-left-color: #4b5563;
        }
    </style>

    <script>
        const easyMDE = new EasyMDE({
            element: document.getElementById('materialContent'),
            placeholder: 'Write your lesson content here using Markdown...\n\nYou can use:\n- **Bold** and *Italic* text\n- # Headers\n- Lists and bullet points\n- Code blocks\n- Links and images\n- And much more!',
            spellChecker: false,
            autosave: {
                enabled: true,
                uniqueId: "material_content",
                delay: 1000,
            },
            toolbar: [
                "bold", "italic", "heading", "|",
                "quote", "unordered-list", "ordered-list", "|",
                "link", "image", "code", "|",
                "preview", "side-by-side", "fullscreen", "|",
                "guide"
            ],
            previewRender: function(plainText) {
                // Custom preview rendering
                return this.parent.markdown(plainText);
            },
            renderingConfig: {
                singleLineBreaks: false,
                codeSyntaxHighlighting: true,
            },
            minHeight: "300px",
            maxHeight: "600px",
        });
    </script>
@endsection
