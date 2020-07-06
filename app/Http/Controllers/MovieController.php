<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\ViewModels\MoviesViewModel;
use App\ViewModels\SingleMovieViewModel;
use Facades\App\Services\TheMovieDbService;

class MovieController extends Controller
{
    public function index()
    {
        return view('movies.index', new MoviesViewModel(
            Arr::get(TheMovieDbService::getPopularMovies(), 'results', []),
            Arr::get(TheMovieDbService::getPlayingNowMovies(), 'results', []),
            Arr::get(TheMovieDbService::getMovieGenres(), 'genres', []),
        ));
    }

    public function show(string $movieId)
    {
        return view('movies.show', new SingleMovieViewModel(
            TheMovieDbService::getMovieDetails($movieId)
        ));
    }
}
