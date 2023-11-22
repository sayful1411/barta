<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
</head>

<body class="bg-gray-100">
    @include('includes.header')

    <main class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">

        @yield('content')

    </main>

    @include('includes.footer')
    @stack('scripts')
</body>

</html>
