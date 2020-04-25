<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class TheMovieDbService
{
    private PendingRequest $client;

    public function __construct(Factory $client, array $config)
    {
        $this->client = $client->retry(3, 100)->withToken(Arr::get($config, 'token'));

        $this->client->baseUrl(Arr::get($config, 'domain', ''));
    }

    /**
     * Retrieve the list of popular movies on TMDB
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getPopularMovies()
    {
        return $this->makeGetRequest('movie/now_playing');
    }

    /**
     * Retrieve the list of "playing now" movies on TMDB
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getPlayingNowMovies()
    {
        return $this->makeGetRequest('movie/popular');
    }

    /**
     * Retrieve the list of movie genres on TMDB
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getGenres()
    {
        return $this->makeGetRequest('genre/movie/list');
    }

    /**
     * Gets the details of a single movie
     *
     * @param string $movieId The movie id
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getMovieDetails(string $movieId)
    {
        return $this->makeGetRequest("movie/{$movieId}", [
            'append_to_response' => 'credits,videos,images'
        ]);
    }

    /**
     * Search the TMDB for a particularq uery movie
     *
     * @param string $query
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function searchMovie(string $query)
    {
        return $this->makeGetRequest('search/movie', compact('query'));
    }

    /**
     * Retrieve the list of popular actors on TMDB
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getPopularActors(int $page = 1)
    {
        return $this->makeGetRequest('person/popular', compact('page'));
    }

    /**
     * Gets the details of a single actor
     *
     * @param string $actorId The actor id
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getActorDetails(string $actorId)
    {
        return $this->makeGetRequest("person/{$actorId}", [
            'append_to_response' => 'external_ids,combined_credits'
        ]);
    }

    /**
     * Make a GET request to TMDB
     *
     * @param string $path
     * @param array|null $options
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function makeGetRequest(string $path, array $options = null)
    {
        try {
            $response = $this->client->get($path, $options);

            return $response->json();
        } catch (RequestException $e) {
            $this->handleException($e);
        }
    }

    /**
     * Handle exception thrown during request
     *
     * @param \Illuminate\Http\Client\RequestException $exception
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function handleException(RequestException $exception)
    {
        $response = $exception->response;

        if (in_array($status = $response->status(), [404, 422])) {
            throw new NotFoundHttpException(null, $exception, $status);
        }

        Log::alert(
            "An error occurred with status code `{$response->status()}` and message `{$exception->getMessage()}`",
            $response->json()
        );

        throw new ServiceUnavailableHttpException(null, $exception->getMessage(), $exception);
    }
}
