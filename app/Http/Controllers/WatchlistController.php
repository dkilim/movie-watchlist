<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatchlistRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\WatchlistResource;
use App\Models\Watchlist;
use App\Models\User;
use App\Services\WatchlistService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WatchlistController extends Controller
{
    private WatchlistService $watchlistService;
    public function __construct(WatchlistService $watchlistService)
    {
        $this->watchlistService = $watchlistService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WatchlistResource::collection(Watchlist::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WatchlistRequest $request)
    {
        try
        {
            $watchlist = Watchlist::create($request->only(['user_id', 'movie_id']));
            $watchlist->movies()->attach($request->input('movies'));

            return response(new WatchlistResource($watchlist), Response::HTTP_CREATED);
        }
        catch (\Exception $e)
        {
            return response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
       return $this->watchlistService->getUserWatchlist($user_id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $watchlist = Watchlist::find($id);
        if ($watchlist)
        {
            $watchlist->movies()->sync($request->input('movies'));

            return response(new WatchlistResource($watchlist->load('movies')), Response::HTTP_ACCEPTED);
        }

        return \response(['message' => "Watchlist with id= $id was not found"], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Watchlist::destroy($id);

        return response([null, Response::HTTP_NO_CONTENT]);
    }
}
