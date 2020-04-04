<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.domain') . '/movie/popular')
            ->json()['results'];

        $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.domain') . '/genre/movie/list')
            ->json()['genres'];

        $genres = collect($genresArray)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });

        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.domain') . '/movie/now_playing')
            ->json()['results'];

        return view('movies.index', compact('popularMovies', 'genres', 'nowPlayingMovies'));
    }

    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.domain') . "/movie/{$id}?append_to_response=credits,videos,images")
            ->json();

        return view('movies.show', compact('movie'));
    }
}
