<?php

namespace App\Services;

use App\Http\Requests\AddMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MovieService
{
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }


    public function addMovie(AddMovieRequest $request)
    {
        try
        {
            return Movie::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $request->input('image'),
                'rating' => $request->inpu('rating'),
                'slug' => Str::slug($request->input('title'), '-')
            ]);
        }
        catch (\PDOException $e)
        {
            return response(['error'=> $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

    }

    public function  updateMovie(Request $request,int|string $id)
    {
        try
        {
            if (ctype_digit($id))
            {
                $movie = Movie::find($id);
            }
            else
            {
                $movie = Movie::where('slug', $id)->firstOrFail();
            }

            $movie->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $request->input('image'),
                'rating' => $request->input('rating'),
                'slug' => Str::slug($request->input('title'),'-')
            ]);
            $movie->genres()->sync($request->input('genres'));

            return \response(new MovieResource($movie->load('genres')), Response::HTTP_ACCEPTED);
        }
        catch (\Exception $e)
        {
            return \response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getMovie(string $id)
    {

        if (ctype_digit($id))
        {

            return Movie::with('genres')->find($id);
        }
        else
        {
//            die('test');
            return Movie::with('genres')->where('slug', $id)->firstOrFail();

        }
    }

    public function getMoviesWithFilters(Request $request)
    {
        $filters = [];

        if ($request->has('title'))
        {
            $filters['title'] = $request->input('title');
        }
        elseif ($request->has('genre'))
        {
            $filters['genre'] = $request->input('genre');
        }
        elseif ($request->has('rating'))
        {
            $filters['rating'] = $request->input('rating');
        }

        return $this->movieRepository->getMoviesWithFilters($filters);
    }
}
