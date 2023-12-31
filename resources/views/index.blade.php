@extends('layouts.app')

@section('title', 'Home - Barta')

@section('content')
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Barta Create Post Card -->
    @error('barta')
        <div class="p-2 m-0 text-sm text-red-500 rounded-lg" role="alert">
            {{ $message }}
        </div>
    @enderror
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3 @error('barta') border-2 border-red-500 @enderror">
        @csrf
        <!-- Create Post Card Top -->
        <div>
            <div class="flex items-start /space-x-3/">
                {{-- User Avatar --}}
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ auth()->user()->avatar_url }}"
                        alt="{{ auth()->user()->fname }}">
                </div>
                <!-- Content -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea class="block w-full p-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                        name="barta" rows="2" placeholder="What's going on, {{ auth()->user()->fname }}?">{{ old('barta') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Create Post Card Bottom -->
        <div>
            <div x-data="imgPreview">
                <input accept="image/*" x-ref="myFile" @change="previewFile" type="file" name="picture" id="picture"
                    class="hidden">
                <template x-if="imgsrc">
                    <p>
                        <img :src="imgsrc" class="max-w-full rounded mb-5">
                    </p>
                </template>
            </div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-between">
                <div class="flex gap-4 text-gray-600">
                    <!-- Upload Picture Button -->
                    <div>
                        <label for="picture"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">
                            <span class="sr-only">Picture</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                                </path>
                            </svg>
                        </label>
                    </div>
                    <!-- /Upload Picture Button -->

                    <!-- GIF Button -->
                    <!--                <button-->
                    <!--                  type="button"-->
                    <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                    <!--                  <span class="sr-only">GIF</span>-->
                    <!--                  <svg-->
                    <!--                    xmlns="http://www.w3.org/2000/svg"-->
                    <!--                    fill="none"-->
                    <!--                    viewBox="0 0 24 24"-->
                    <!--                    stroke-width="1.5"-->
                    <!--                    stroke="currentColor"-->
                    <!--                    class="w-6 h-6">-->
                    <!--                    <path-->
                    <!--                      stroke-linecap="round"-->
                    <!--                      stroke-linejoin="round"-->
                    <!--                      d="M12.75 8.25v7.5m6-7.5h-3V12m0 0v3.75m0-3.75H18M9.75 9.348c-1.03-1.464-2.698-1.464-3.728 0-1.03 1.465-1.03 3.84 0 5.304 1.03 1.464 2.699 1.464 3.728 0V12h-1.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />-->
                    <!--                  </svg>-->
                    <!--                </button>-->
                    <!-- /GIF Button -->

                    <!-- Emoji Button -->
                    <!--                <button-->
                    <!--                  type="button"-->
                    <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                    <!--                  <span class="sr-only">Emoji</span>-->
                    <!--                  <svg-->
                    <!--                    xmlns="http://www.w3.org/2000/svg"-->
                    <!--                    fill="none"-->
                    <!--                    viewBox="0 0 24 24"-->
                    <!--                    stroke-width="1.5"-->
                    <!--                    stroke="currentColor"-->
                    <!--                    class="w-6 h-6">-->
                    <!--                    <path-->
                    <!--                      stroke-linecap="round"-->
                    <!--                      stroke-linejoin="round"-->
                    <!--                      d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />-->
                    <!--                  </svg>-->
                    <!--                </button>-->
                    <!-- /Emoji Button -->
                </div>

                <div>
                    <!-- Post Button -->
                    <button type="submit"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                        Post
                    </button>
                    <!-- /Post Button -->
                </div>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Post Card Bottom -->
    </form>
    <!-- /Barta Create Post Card -->

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        <!-- Barta Card -->
        <livewire:load-more-posts />
        <!-- /Barta Card -->

    </section>
    <!-- Newsfeed -->

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // auto expand post area
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize() {
            var el = this;
            setTimeout(function() {
                el.style.cssText = 'min-height:37px; height: 37px;';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
            }, 0);
        }

        // post delete
        $(document).ready(function() {
            $('.deletePostBtn').click(function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                $('#post_id').val(postId);
            });
        });

        // image preview
        document.addEventListener('alpine:init', () => {
            Alpine.data('imgPreview', () => ({
                imgsrc: null,
                previewFile() {
                    let file = this.$refs.myFile.files[0];
                    if (!file || file.type.indexOf('image/') === -1) return;
                    this.imgsrc = null;
                    let reader = new FileReader();

                    reader.onload = e => {
                        this.imgsrc = e.target.result;
                    }

                    reader.readAsDataURL(file);

                }
            }))
        });
    </script>
@endpush
