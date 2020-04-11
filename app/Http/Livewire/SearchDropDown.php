<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\TheMovieDbService;

class SearchDropDown extends Component
{
    public string $search = '';

    public function render()
    {
        $searchedMovies = [];

        if (strlen($this->search) >= 3) {
            $movieDb = resolve(TheMovieDbService::class);

            $searchedMovies = $movieDb->searchMovie($this->search);
        }

        return view('livewire.search-drop-down', compact('searchedMovies'));
    }
}
