<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\ViewModels\ActorsViewModel;
use App\ViewModels\SingleActorViewModel;
use Facades\App\Services\TheMovieDbService;

class ActorController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) (is_numeric($request->page) && $request->page > 0 ? $request->page : 1);

        try {
            return view('actors.index', new ActorsViewModel(
                Arr::get(TheMovieDbService::getPopularActors($page), 'results', [])
            ));
        } catch (Exception $e) {
            if ($e->getCode() === 422) {
                return response()->noContent();
            }

            throw $e;
        }
    }

    public function show(string $actorId)
    {
        return view('actors.show', new SingleActorViewModel(
            TheMovieDbService::getActorDetails($actorId)
        ));
    }
}
