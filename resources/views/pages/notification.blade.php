@extends('layouts.app')

@section('title', 'Single Post - Barta')

@section('content')


<dl class="max-w-lg text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
    <div class="flex flex-col pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Comment </dt>
        <dd class="text-lg text-black font-semibold">John Doe commented on your post</dd>
    </div>
    <div class="flex flex-col py-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">React </dt>
        <dd class="text-lg text-black font-semibold">Smith reacted to your post</dd>
    </div>
    <div class="flex flex-col pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Comment </dt>
        <dd class="text-lg text-black font-semibold">John Doe commented on your post</dd>
    </div>
    <div class="flex flex-col py-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">React </dt>
        <dd class="text-lg text-black font-semibold">Smith reacted to your post</dd>
    </div>
</dl>


@endsection
