@extends('layouts.app')

@section('title', 'Setting - Barta')

@section('content')
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
            role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    <!-- Password Change Form -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-xl font-semibold leading-7 text-gray-900">
                    Change Password
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    This information will be changed so be rember what you
                    input.
                </p>

                <div class="mt-10 border-b border-gray-900/10 pb-12">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <!-- Current Password -->
                        <div class="col-span-full">
                            <label for="current_password" class="block text-sm font-medium leading-6 text-gray-900">Current
                                Password</label>
                            <div class="mt-2">
                                <input id="current_password" name="current_password" type="password"
                                    autocomplete="current-password" placeholder="••••••••"
                                    class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('current_password') border-2 border-red-600 @enderror" />
                            </div>
                            @error('current_password','updatePassword')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="col-span-full">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">New
                                Password</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password') border-2 border-red-600 @enderror" />
                            </div>
                            @error('password','updatePassword')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-span-full">
                            <label for="password_confirmation"
                                class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                            <div class="mt-2">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="confirm-password" placeholder="••••••••"
                                    class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password_confirmation') border-2 border-red-600 @enderror" />
                            </div>
                            @error('password_confirmation','updatePassword')
                                <div class="p-2 mb-1 text-sm text-red-500 rounded-lg" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
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
    <!-- /Password Change Form -->
    {{-- delete user --}}
    @include('pages.profiles.delete-user-form')
@endsection
