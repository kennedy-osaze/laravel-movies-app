<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Services\TheMovieDbService;
use App\ViewModels\MoviesViewModel;
use App\ViewModels\SingleMovieViewModel;

class MovieController extends Controller
{
    private TheMovieDbService $movieDb;

    public function __construct(TheMovieDbService $movieDb)
    {
        $this->movieDb = $movieDb;
    }

    public function index()
    {
        return view('movies.index', new MoviesViewModel(
            Arr::get($this->movieDb->getPopularMovies(), 'results', []),
            Arr::get($this->movieDb->getPlayingNowMovies(), 'results', []),
            Arr::get($this->movieDb->getGenres(), 'genres', []),
        ));
    }

    public function show(string $movieId)
    {
        return view('movies.show', new SingleMovieViewModel(
            $this->movieDb->getMovieDetails($movieId)
        ));
    }
}
