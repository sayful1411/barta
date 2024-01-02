@extends('layouts.app')

@section('title', 'Single Post - Barta')

@section('content')


    <dl class="max-w-lg text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
        @foreach ($notifications as $item)
            <div class="flex flex-col pb-3 py-5 px-2">
                <a href="{{ $item['data']['post_url'] }}">
                    <dd class="text-lg text-black font-semibold">{{ $item['data']['message'] }}</dd>
                </a>
            </div>
        @endforeach
    </dl>


@endsection
