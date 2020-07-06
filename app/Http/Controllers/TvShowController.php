<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\ViewModels\TvShowsViewModel;
use App\ViewModels\SingleTvShowViewModel;
use Facades\App\Services\TheMovieDbService;

class TvShowController extends Controller
{
    public function index()
    {
        return view('tv-shows.index', new TvShowsViewModel(
            Arr::get(TheMovieDbService::getPopularTvShows(), 'results', []),
            Arr::get(TheMovieDbService::getTopRatedTvShows(), 'results', []),
            Arr::get(TheMovieDbService::getTvGenres(), 'genres', []),
        ));
    }

    public function show(string $showId)
    {
        return view('tv-shows.show', new SingleTvShowViewModel(
            TheMovieDbService::getTvShowDetails($showId)
        ));
    }
}
