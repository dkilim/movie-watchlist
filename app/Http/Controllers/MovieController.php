<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->movieService->getMoviesWithFilters($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddMovieRequest $request)
    {
        if (\Gate::allows('create'))
        {
            $movie = $this->movieService->addMovie($request);

            $movie->genres()->attach($request->input('genres'));
            return response(new MovieResource($movie), Response::HTTP_CREATED);
        }

        return \response(['message' => 'Access denied!'], Response::HTTP_FORBIDDEN);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $movie = $this->movieService->getMovie($id);

        if ($movie)
        {
            return response(new MovieResource($movie));
        }

        return \response(['message' => 'Bad request'], Response::HTTP_BAD_REQUEST);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->movieService->updateMovie($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Movie::destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
