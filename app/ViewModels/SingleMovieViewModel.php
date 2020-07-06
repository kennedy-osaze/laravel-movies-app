<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class SingleMovieViewModel extends ViewModel
{
    public array $movie;

    public function __construct(array $movie)
    {
        $this->movie = $movie;
    }

    public function movie(): Collection
    {
        $videos = collect($this->movie['videos']['results']);

        return collect($this->movie)->merge([
            'poster_url' => isset($this->movie['poster_path'])
                ? 'https://image.tmdb.org/t/p/w500/' . ltrim($this->movie['poster_path'], '/')
                : 'https://via.placeholder.com/500x750',
            'slug' => Str::slug($this->movie['title']),
            'vote_average' => ($this->movie['vote_average'] * 10) . '%',
            'release_date' => Carbon::parse($this->movie['release_date'])->format('M d, Y'),
            'genres' => collect($this->movie['genres'])->pluck('name')->implode(', '),
            'crew' => collect($this->movie['credits']['crew'])->take(2),
            'cast' => $this->formatCast(),
            'images' => $this->formatImageSizes(),
            'video_url' => 'https://www.youtube.com/embed/' . ltrim($videos->pluck('key')->first(), '/'),
        ]);
    }

    private function formatCast(): Collection
    {
        return collect($this->movie['credits']['cast'])->take(5)->map(function ($cast) {
            return [
                'id' => $cast['id'],
                'profile_url' => isset($cast['profile_path'])
                    ? 'https://image.tmdb.org/t/p/w300/' . ltrim($cast['profile_path'], '/')
                    : 'https://via.placeholder.com/300x450',
                'slug' => Str::slug($cast['name']),
                'name' => ucwords($cast['name']),
                'character' => ucwords($cast['character']),
            ];
        });
    }

    private function formatImageSizes(): Collection
    {
        return collect($this->movie['images']['backdrops'])->take(9)->map(function ($image) {
            return [
                'original_url' => 'https://image.tmdb.org/t/p/original/' . ltrim($image['file_path'], '/'),
                'file_url' => 'https://image.tmdb.org/t/p/w500/' . ltrim($image['file_path'], '/'),
            ];
        });;
    }
}
