@extends('layouts.app')

@section('title', 'Edit Profile - Barta')

@section('content')
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
            role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    <!-- Profile Edit Form -->
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-xl font-semibold leading-7 text-gray-900">
                    Edit Profile
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    This information will be displayed publicly so be careful what you
                    share.
                </p>

                <div class="mt-10 border-b border-gray-900/10 pb-12">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="fname" class="block text-sm font-medium leading-6 text-gray-900">First
                                name</label>
                            <div class="mt-2">
                                <input type="text" name="fname" id="fname" autocomplete="given-name"
                                    value="{{ auth()->user()->fname }}"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6  @error('fname') border-2 border-red-600 @enderror" />
                            </div>
                            @error('fname')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="lname" class="block text-sm font-medium leading-6 text-gray-900">Last
                                name</label>
                            <div class="mt-2">
                                <input type="text" name="lname" id="lname" value="{{ auth()->user()->lname }}"
                                    autocomplete="family-name"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('lname') border-2 border-red-600 @enderror" />
                            </div>
                            @error('lname')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-span-full">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email"
                                    value="{{ auth()->user()->email }}"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('email') border-2 border-red-600 @enderror" />
                            </div>
                            @error('email')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="bio" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                        <div class="mt-2">
                            <textarea id="bio" name="bio" rows="3"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('bio') border-2 border-red-600 @enderror">{{ auth()->user()->bio }}</textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Write a few sentences about yourself.
                        </p>
                        @error('bio')
                            <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </button>
            <button type="submit"
                class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Save
            </button>
        </div>
    </form>
    <!-- /Profile Edit Form -->
@endsection
