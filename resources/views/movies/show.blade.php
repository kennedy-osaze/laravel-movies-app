@extends('layouts.app')

@section('title', 'Movie Info')

@section('content')
    <div id="movie-info" class="border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <img src="https://i.picsum.photos/id/866/480/640.jpg" alt="movie" class="w-64 md:w-96">

            <div class="md:ml-24">
                <h2 class="text-4xl font-semibold">Movie Title</h2>
                <div class="flex flex-wrap items-center text-gray-400 text-sm">
                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
                    <span class="ml-1">85%</span>
                    <span class="mx-2">|</span>
                    <span>Feb 20, 2013</span>
                    <span class="mx-2">|</span>
                    <span>Action, Triller, Comedy</span>
                </div>

                <p class="text-gray-300 mt-8">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque necessitatibus esse iusto repellat voluptatibus distinctio laborum aliquam reiciendis officia beatae perferendis magnam itaque exercitationem natus perspiciatis dolore, quasi, mollitia reprehenderit!
                </p>

                <div class="mt-12">
                    <h4 class="text-white font-semibold">Featured Crew</h4>
                    <div class="flex mt-4">
                        <div>
                            <div>John Doe</div>
                            <div class="text-sm text-gray-400">Screenplay, Director, Story</div>
                        </div>
                        <div class="ml-8">
                            <div>Cindy Okafor</div>
                            <div class="text-sm text-gray-400">Screenplay</div>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <a href="#" class="flex inline-flex items-center rounded bg-orange-500 text-gray-900 text-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150">
                        <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                        <span class="ml-2">Watch Trailer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="movie-cast" class="border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-2xl font-semibold">Cast</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <div class="mt-8">
                    <a href="#">
                        <img src="https://www.openhost.co.za/download/bootmin/img/avatar_lg.jpg" alt="actor" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>

                    <div class="mt-2">
                        <a href="#" class="text-lg mt-2 hover:text-gray-300">Real Name</a>
                        <div class="text-gray-400 text-sm">
                            Character Name
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://www.openhost.co.za/download/bootmin/img/avatar_lg.jpg" alt="actor" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>

                    <div class="mt-2">
                        <a href="#" class="text-lg mt-2 hover:text-gray-300">Real Name</a>
                        <div class="text-gray-400 text-sm">
                            Character Name
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://www.openhost.co.za/download/bootmin/img/avatar_lg.jpg" alt="actor" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>

                    <div class="mt-2">
                        <a href="#" class="text-lg mt-2 hover:text-gray-300">Real Name</a>
                        <div class="text-gray-400 text-sm">
                            Character Name
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://www.openhost.co.za/download/bootmin/img/avatar_lg.jpg" alt="actor" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>

                    <div class="mt-2">
                        <a href="#" class="text-lg mt-2 hover:text-gray-300">Real Name</a>
                        <div class="text-gray-400 text-sm">
                            Character Name
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://www.openhost.co.za/download/bootmin/img/avatar_lg.jpg" alt="actor" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>

                    <div class="mt-2">
                        <a href="#" class="text-lg mt-2 hover:text-gray-300">Real Name</a>
                        <div class="text-gray-400 text-sm">
                            Character Name
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="movie-images">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-2xl font-semibold">Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="mt-8">
                    <a href="#">
                        <img src="https://image.tmdb.org/t/p/w1066_and_h600_bestv2/5myQbDzw3l8K9yofUXRJ4UTVgam.jpg" alt="image-1">
                    </a>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://image.tmdb.org/t/p/w1066_and_h600_bestv2/5myQbDzw3l8K9yofUXRJ4UTVgam.jpg" alt="image-1">
                    </a>
                </div>
                <div class="mt-8">
                    <a href="#">
                        <img src="https://image.tmdb.org/t/p/w1066_and_h600_bestv2/5myQbDzw3l8K9yofUXRJ4UTVgam.jpg" alt="image-1">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
