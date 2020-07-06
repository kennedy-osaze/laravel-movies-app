@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-tv-shows">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular TV Shows</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($popularTvShows as $show)
                    <x-tv-show-card :show="$show"/>
                @endforeach

            </div>
        </div>

        <div class="top-rated-shows py-24">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Top Rated TV Shows</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($topRatedTvShows as $show)
                    <x-tv-show-card :show="$show"/>
                @endforeach
            </div>
        </div>
    </div>
@endsection
