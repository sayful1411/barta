@extends('layouts.guest')

@section('title', 'Login - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->

            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email" placeholder="bruce@wayne.com"
                        value="{{ old('email') }}"
                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('email') border-2 border-red-600 @enderror" />
                </div>
                @error('email')
                    <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-black hover:text-black">Forgot password?</a>
                    </div>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password') border-2 border-red-600 @enderror" />
                </div>
                @error('password')
                    <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                    Sign in
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Don't have an account yet?
            <a href="{{ route('register') }}" class="font-semibold leading-6 text-black hover:text-black">Sign Up</a>
        </p>
    </div>
@endsection
