## Laravel Movie App

### Installation
1. Clone repository
2. `cd` into the folder and run `composer install`
3. Copy the variables in `.env.example` file into your `.env` file
4. Run `php artisan key:generate`
5. Generate your own TheMovieDB api credentials [here](https://www.themoviedb.org/documentation/api) and set the `TMDB_TOKEN` variable in the `.env` with your "access token"
6. Run your app `php artisan serve`
