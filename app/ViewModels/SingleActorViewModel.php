<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class SingleActorViewModel extends ViewModel
{
    public array $actor;

    public function __construct(array $actor)
    {
        $this->actor = $actor;
    }

    public function actor(): Collection
    {
        $birthday = Carbon::parse($this->actor['birthday']);

        return collect($this->actor)->merge([
            'slug' => Str::slug($this->actor['name']),
            'profile_url' => isset($this->actor['profile_path'])
                ? 'https://image.tmdb.org/t/p/w300/' . ltrim($this->actor['profile_path'], '/')
                : 'https://via.placeholder.com/300x450',
            'birthday' => $birthday->format('M d, Y'),
            'age' => $birthday->age,
        ]);
    }

    public function socials()
    {
        $socials = $this->actor['external_ids'];

        return collect($socials)->merge([
            'facebook' => $socials['facebook_id'] ? 'https://facebook.com/' . $socials['facebook_id'] : null,
            'twitter' => $socials['twitter_id'] ? 'https://twitter.com/' . $socials['twitter_id'] : null,
            'instagram' => $socials['instagram_id'] ? 'https://twitter.com/' . $socials['instagram_id'] : null,
        ]);
    }

    public function popularMovies()
    {
        return collect($this->actor['combined_credits']['cast'])
            ->where('media_type', 'movie')
            ->sortByDesc('popularity')
            ->take(5)
            ->map(function ($movie) {
                return [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'slug' => Str::slug($movie['title']),
                    'poster_url' => isset($movie['poster_path'])
                        ? 'https://image.tmdb.org/t/p/w185/' . ltrim($movie['poster_path'], '/')
                        : 'https://via.placeholder.com/185x278',
                ];
            })
            ->all();
    }

    public function credits()
    {
        return collect($this->actor['combined_credits']['cast'])
            ->map(function ($movie) {
                $releaseDate = $movie['release_date'] ?? $movie['first_air_date'] ?? null;

                return [
                    'release_date' => $releaseDate,
                    'release_year' => transform($releaseDate, fn ($value) => Carbon::parse($value)->format('Y'), 'Not set yet'),
                    'title' => $movie['title'] ?? $movie['name'] ?? 'Untitled',
                    'character' => $movie['character'] ?? 'Unknown',
                    'page_url' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : '#',
                ];
            })
            ->sortByDesc('release_date')
            ->all();
    }
}
