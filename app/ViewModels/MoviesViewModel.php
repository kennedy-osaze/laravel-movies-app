<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class MoviesViewModel extends ViewModel
{
    public array $popularMovies;

    public array $nowPlayingMovies;

    public Collection $genres;

    public function __construct(
        array $popularMovies,
        array $nowPlayingMovies,
        array $genres
    ) {
        $this->popularMovies = $popularMovies;
        $this->nowPlayingMovies = $nowPlayingMovies;
        $this->genres = collect($genres);
    }

    public function popularMovies(): Collection
    {
        return $this->formatMovies($this->popularMovies);
    }

    public function nowPlayingMovies(): Collection
    {
        return $this->formatMovies($this->nowPlayingMovies);
    }

    private function formatMovies(array $movies): Collection
    {
        return collect($movies)->map(function ($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'slug' => Str::slug($movie['title']),
                'poster_url' => 'https://image.tmdb.org/t/p/w500/' . ltrim($movie['poster_path'], '/'),
                'vote_average' => ($movie['vote_average'] * 10) . '%',
                'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
                'genres' => $this->genres->whereIn('id', $movie['genre_ids'])->pluck('name')->implode(', '),
            ];
        });
    }
}
