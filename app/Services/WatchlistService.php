<?php

namespace App\Services;

use App\Http\Resources\MovieResource;
use App\Models\User;
use App\Models\Watchlist;
use App\Repositories\MovieRepository;
use App\Repositories\WatchlistRepository;
use Symfony\Component\HttpFoundation\Response;

class WatchlistService
{
    private WatchlistRepository $watchlistRepository;

    public function __construct()
    {
        $this->watchlistRepository = new WatchlistRepository();
    }

    public function getUserWatchlist($user_id)
    {
        $movieRepository = new MovieRepository();
        return $movieRepository->getWatchlistMoviesByWatchlistId($user_id);
    }

    public function createWatchlist(int $user_id)
    {
        try
        {
            Watchlist::create([
                "user_id" => $user_id
            ]);
        }
        catch (\PDOException $e)
        {
            response(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
