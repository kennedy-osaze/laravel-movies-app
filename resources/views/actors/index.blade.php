@extends('layouts.app')

@section('title', 'Actors')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="popular-movies">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">
            Popular Actors
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach ($popularActors as $actor)
                <div id="actor-{{ $actor['id'] }}" class="actor mt-8">
                    <a href="{{ route('actors.show', $actor['id']) }}">
                        <img src="{{ $actor['profile_url'] }}" alt="actor-{{ $actor['slug'] }}" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                    <div class="mt-2">
                        <a href="{{ route('actors.show', $actor['id']) }}" class="text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
                        <div class="text-sm truncate text-gray-400">{{ $actor['known_for'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="page-load-status my-8">
        <div class="flex justify-center">
            <div class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</div>
            <p class="infinite-scroll-last">No result to show</p>
            <p class="infinite-scroll-error">Unable to retrieve actors</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>

    <script>
        const element = document.querySelector('.grid');
        const infiniteScroll = new InfiniteScroll(element, {
            path: "{{ route('actors.index', ['page' => '']) }}" + '@{{#}}',
            append: '.actor',
            status: '.page-load-status',
        });
    </script>
@endpush
