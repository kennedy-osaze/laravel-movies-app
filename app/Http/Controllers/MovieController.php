<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TheMovieDbService;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    private TheMovieDbService $movieDb;

    public function __construct(TheMovieDbService $movieDb)
    {
        $this->movieDb = $movieDb;
    }

    public function index()
    {
        $popularMovies = $this->movieDb->getPopularMovies();

        $nowPlayingMovies = $this->movieDb->getPlayingNowMovies();

        $genres = $this->movieDb->getGenres()['genres'];

        return view('movies.index', compact('popularMovies', 'genres', 'nowPlayingMovies'));
    }

    public function show(string $id)
    {
        $movie = $this->movieDb->getMovieDetails($id);

        return view('movies.show', compact('movie'));
    }
}
