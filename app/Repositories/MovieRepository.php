<?php

namespace App\Repositories;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class MovieRepository
{
    public function getWatchlistMoviesByWatchlistId($user_id)
    {
        try
        {
            $watchlist = Movie::query()
                ->join('watchlist_movies as wlm', 'wlm.movie_id', '=', 'movies.id')
                ->join('watchlists as wl','wl.id', '=', 'wlm.watchlist_id')
                ->where('wl.user_id', '=', $user_id)
                ->select('movies.*')
                ->with('genres')
                ->paginate(5);


            return MovieResource::collection($watchlist);
        }
        catch (QueryException $e)
        {
            return \response(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    public function getMoviesWithFilters(array $filters)
    {
        if ($filters)
        {
//            die('test');
            $query = Movie::query();
            if (isset($filters['title']))
            {
                $query->where('title', 'like', '%'.$filters['title'].'%');
            }
            if (isset($filters['genre']))
            {
                $query->join('movie_genres as mg','mg.movie_id', '=', 'movies.id')
                    ->join('genres as g', 'g.id', '=', 'mg.genre_id')
                    ->where('g.name', '=',$filters['genre']);

            }
            if (isset($filters['rating']))
            {
                $query->where('rating', '>=', $filters['rating']);
            }

            $movies = $query->select('movies.*')
                            ->with('genres')
                            ->paginate();

            return MovieResource::collection($movies);
        }

        return MovieResource::collection(MovieResource::collection(Movie::with('genres')->paginate()));
    }
}
