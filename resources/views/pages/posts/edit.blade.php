@extends('layouts.app')

@section('title', 'Edit Post - Barta')

@section('content')
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
            role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    <!-- User Specific Posts Feed -->
    @error('barta')
        <div class="p-2 m-0 text-sm text-red-500 rounded-lg" role="alert">
            {{ $message }}
        </div>
    @enderror
    <!-- Barta Card -->
    <form method="POST" action="{{ route('posts.update', $post->uuid) }}" enctype="multipart/form-data"
        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3 @error('barta') border-2 border-red-500 @enderror">
        @csrf
        @method('PUT')
        <!-- Create Post Card Top -->
        <div>
            <div class="flex items-start /space-x-3/">
                <!-- Content -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea class="block w-full p-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                        name="barta" id="bartaTextarea" rows="2">{{ $post->description . old('barta') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Create Post Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end">
                <div>
                    <!-- Post Button -->
                    <button type="submit"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                        Update Post
                    </button>
                    <!-- /Post Button -->
                </div>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Post Card Bottom -->
    </form>

    <!-- /Barta Card -->
    <!-- /User Specific Posts Feed -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('bartaTextarea');
            autosize(textarea);

            textarea.addEventListener('keydown', function() {
                autosize(textarea);
            });

            function autosize(el) {
                setTimeout(function() {
                    el.style.cssText = 'height:' + el.scrollHeight + 'px';
                }, 0);
            }
        });
    </script>
@endpush
