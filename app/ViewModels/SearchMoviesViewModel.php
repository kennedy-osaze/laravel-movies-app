<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class SearchMoviesViewModel extends ViewModel
{
    public array $searchedMovies;

    public function __construct(array $searchedMovies)
    {
        $this->searchedMovies = $searchedMovies;
    }

    public function searchedMovies(): array
    {
        return collect($this->searchedMovies)->take(10)->map(function ($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'slug' => Str::slug($movie['title']),
                'poster_path' => isset($movie['poster_path'])
                    ? 'https://image.tmdb.org/t/p/w92/' . ltrim($movie['poster_path'], '/')
                    : 'https://via.placeholder.com/50x75.jpg',
            ];
        })->all();
    }
}
