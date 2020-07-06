<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class SingleTvShowViewModel extends ViewModel
{
    public array $show;

    public function __construct(array $show)
    {
        $this->show = $show;
    }

    public function show(): Collection
    {
        $videos = collect($this->show['videos']['results']);

        return collect($this->show)->merge([
            'poster_url' => isset($this->show['poster_path'])
                ? 'https://image.tmdb.org/t/p/w500/' . ltrim($this->show['poster_path'], '/')
                : 'https://via.placeholder.com/500x750',
            'slug' => Str::slug($this->show['name']),
            'vote_average' => ($this->show['vote_average'] * 10) . '%',
            'first_air_date' => Carbon::parse($this->show['first_air_date'])->format('M d, Y'),
            'genres' => collect($this->show['genres'])->pluck('name')->implode(', '),
            'crew' => collect($this->show['credits']['crew'])->take(2),
            'cast' => $this->formatCast(),
            'images' => $this->formatImageSizes(),
            'video_url' => 'https://www.youtube.com/embed/' . ltrim($videos->pluck('key')->first(), '/'),
        ]);
    }

    private function formatCast(): Collection
    {
        return collect($this->show['credits']['cast'])->take(5)->map(function ($cast) {
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
        return collect($this->show['images']['backdrops'])->take(9)->map(function ($image) {
            return [
                'original_url' => 'https://image.tmdb.org/t/p/original/' . ltrim($image['file_path'], '/'),
                'file_url' => 'https://image.tmdb.org/t/p/w500/' . ltrim($image['file_path'], '/'),
            ];
        });;
    }
}
