<!DOCTYPE html>
<html class="html h-full bg-white">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a class="text-center text-6xl font-bold text-gray-900">
                <h1>Barta</h1>
            </a>
            <h1 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Create a new account
            </h1>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <form class="space-y-6" action="{{ route('register.submit') }}" method="POST">
                @csrf
                <!-- First Name -->
                <div>
                    <label for="fname" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                    <div class="mt-2">
                        <input id="fname" name="fname" type="text" autocomplete="fname" placeholder="Alp"
                            value="{{ old('fname') }}"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm  @error('fname') border-2 border-red-600 @enderror" />
                    </div>
                    @error('fname')
                    <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                  <label for="lname" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                  <div class="mt-2">
                      <input id="lname" name="lname" type="text" autocomplete="lname" placeholder="Arslan"
                          value="{{ old('lname') }}"
                          class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('lname') border-2 border-red-600 @enderror" />
                  </div>
                  @error('lname')
                  <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                      {{ $message }}
                  </div>
                  @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                        <input id="username" name="username" type="text" autocomplete="username"
                            value="{{ old('username') }}"
                            placeholder="alparslan1029"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('username') border-2 border-red-600 @enderror" />
                    </div>
                    @error('username')
                    <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email"
                            value="{{ old('email') }}"
                            placeholder="alp.arslan@mail.com"
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
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password"
                            placeholder="••••••••"
                            class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password') border-2 border-red-600 @enderror" />
                    </div>
                    @error('password')
                    <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                  <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                  <div class="mt-2">
                      <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="confirm-password"
                          placeholder="••••••••"
                          class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password') border-2 border-red-600 @enderror" />
                  </div>
                  @error('password_confirmation')
                  <div class="p-2 mb-1 text-sm text-red-500 rounded-lg dark:text-red-500" role="alert">
                      {{ $message }}
                  </div>
                  @enderror
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Register
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already a member?
                <a href="{{ route('login') }}" class="font-semibold leading-6 text-black hover:text-black">Sign In</a>
            </p>
        </div>
    </div>
</body>

</html>
