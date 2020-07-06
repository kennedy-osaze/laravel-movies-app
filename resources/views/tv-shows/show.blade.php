@extends('layouts.app')

@section('title', $show['name'])

@section('content')
    <div id="tv-show-info" class="border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <img src="{{ $show['poster_url'] }}" alt="{{ $show['slug'] }}" class="w-64 md:w-96">

            <div class="md:ml-24">
                <h2 class="text-4xl font-semibold">{{ $show['name'] }}</h2>
                <div class="flex flex-wrap items-center text-gray-400 text-sm">
                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
                    <span class="ml-1">{{ $show['vote_average'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $show['first_air_date'] }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $show['genres'] }}</span>
                </div>

                <p class="text-gray-300 mt-8">
                    {{ $show['overview'] }}
                </p>

                <div class="mt-12">
                    <div class="flex mt-4">
                        @foreach ($show['created_by'] as $crew)
                            <div class="mr-8">
                                <div>{{ $crew['name'] }}</div>
                                <div class="text-sm text-gray-400">Creator</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div x-data="{ open: false }">
                    @if (count($show['videos']) > 0)
                        <div class="mt-12">
                            <button
                                class="flex inline-flex items-center rounded bg-orange-500 text-gray-900 text-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150"
                                @click="open = true"
                            >
                                <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                <span class="ml-2">Watch Trailer</span>
                            </button>
                        </div>

                        <div
                            class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                            style="background-color: rgba(0, 0, 0, .5)"
                            x-show.transition.opacity="open"
                            @keydown.escape.window="open = false"
                        >
                            <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                <div class="bg-gray-900 rounded">
                                    <div class="flex justify-end pr-4 pt-2">
                                        <button class="text-3xl leading-none hover:text-gray-300" @click="open = false">&times;</button>
                                    </div>
                                    <div class="modal-body px-8 py-8">
                                        <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%;">
                                            <iframe
                                                src="{{ $show['video_url'] }}"
                                                frameborder="0"
                                                class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                style="border: 0"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen
                                            ></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="tv-show-cast" class="border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-2xl font-semibold">Cast</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($show['cast'] as $cast)
                    <div class="mt-8">
                        <a href="{{ route('actors.show', $cast['id']) }}">
                            <img src="{{ $cast['profile_url'] }}" alt="{{ $cast['slug'] }}" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>

                        <div class="mt-2">
                            <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray-300">{{ $cast['name'] }}</a>
                            <div class="text-gray-400 text-sm">
                                {{ $cast['character'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="tv-show-images" x-data="{ open: false, image: '' }">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-2xl font-semibold">Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($show['images'] as $image)
                    <div class="mt-8">
                        <a
                            href="#"
                            @click.prevent="open = true; image='{{ $image['original_url'] }}'"
                        >
                            <img src="{{ $image['file_url'] }}" alt="backdrop-{{ $loop->index + 1 }}">
                        </a>
                    </div>
                @endforeach
            </div>

            <div
                class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                style="background-color: rgba(0, 0, 0, .5);"
                x-show="open"
                @keydown.escape.window="open = false"
            >
                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                    <div class="bg-gray-900 rounded">
                        <div class="flex justify-end pr-4 pt-2">
                            <button class="text-3xl leading-none hover:text-gray-300" @click="open = false">&times;</button>
                        </div>

                        <div class="modal-body px-8 py-8">
                            <img :src="image" alt="poster">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
