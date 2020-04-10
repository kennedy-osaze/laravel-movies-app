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
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getPopularMovies()
    {
        return $this->makeGetRequest('movie/now_playing');
    }

    /**
     * Retrieve the list of "playing now" movies on TMDB
     *
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getPlayingNowMovies()
    {
        return $this->makeGetRequest('movie/popular');
    }

    /**
     * Retrieve the list of movie genres on TMDB
     *
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getGenres()
    {
        return $this->makeGetRequest('genre/movie/list');
    }

    /**
     * Make a GET request to TMDB
     *
     * @param string $movie The movie id
     *
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getMovieDetails(string $movie)
    {
        return $this->makeGetRequest("movie/{$movie}", [
            'append_to_response' => 'credits,videos,images'
        ]);
    }

    /**
     * Make a GET request to TMDB
     *
     * @param string $path
     * @param array|null $options
     *
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\RequestException
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
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function handleException(RequestException $exception)
    {
        $response = $exception->response;

        if ($response->status() === 404) {
            throw new NotFoundHttpException();
        }

        Log::alert(
            "An error occurred with status code `{$response->status()}` and message `{$exception->getMessage()}`",
            $response->json()
        );

        throw new ServiceUnavailableHttpException();
    }
}
