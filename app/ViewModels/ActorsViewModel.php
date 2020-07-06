<?php

namespace App\ViewModels;

use Illuminate\Support\Str;
use Spatie\ViewModels\ViewModel;

class ActorsViewModel extends ViewModel
{
    public array $popularActors;

    public function __construct(array $popularActors)
    {
        $this->popularActors = $popularActors;
    }

    public function popularActors()
    {
        return collect($this->popularActors)->map(function ($actor) {
            $moviesKnownFor = collect($actor['known_for'])->map(function ($movie) {
                return $movie['name'] ?? $movie['title'];
            });

            return [
                'id'=> $actor['id'],
                'name' => $actor['name'],
                'slug' => Str::slug($actor['name']),
                'profile_url' => $actor['profile_path']
                    ?'https://image.tmdb.org/t/p/w235_and_h235_face/' . ltrim($actor['profile_path'], '/')
                    : 'https://ui-avatars.com/api/?size=235&name=' . $actor['name'],
                'known_for' => $moviesKnownFor->implode(', ')
            ];
        });
    }
}
