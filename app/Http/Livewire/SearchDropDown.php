<?php

namespace App\Http\Livewire;

use Livewire\Component;
use illuminate\Support\Arr;
use App\Services\TheMovieDbService;
use App\ViewModels\SearchMoviesViewModel;

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

        return view(
            'livewire.search-drop-down',
            new SearchMoviesViewModel(
                Arr::get($searchedMovies, 'results', [])
            )
        );
    }
}
