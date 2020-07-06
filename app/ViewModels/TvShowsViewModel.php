<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class TvShowsViewModel extends ViewModel
{
    public array $popularTvShows;

    public array $topRatedTvShows;

    public Collection $genres;

    public function __construct(
        array $popularTvShows,
        array $topRatedTvShows,
        array $genres
    ) {
        $this->popularTvShows = $popularTvShows;
        $this->topRatedTvShows = $topRatedTvShows;
        $this->genres = collect($genres);
    }

    public function popularTvShows(): Collection
    {
        return $this->formatShows($this->popularTvShows);
    }

    public function topRatedTvShows(): Collection
    {
        return $this->formatShows($this->topRatedTvShows);
    }

    private function formatShows(array $tvShows): Collection
    {
        return collect($tvShows)->map(function ($show) {
            return [
                'id' => $show['id'],
                'name' => $show['name'],
                'slug' => Str::slug($show['name']),
                'poster_url' => 'https://image.tmdb.org/t/p/w500/' . ltrim($show['poster_path'], '/'),
                'vote_average' => ($show['vote_average'] * 10) . '%',
                'first_air_date' => Carbon::parse($show['first_air_date'])->format('M d, Y'),
                'genres' => $this->genres->whereIn('id', $show['genre_ids'])->pluck('name')->implode(', '),
            ];
        });
    }
}
