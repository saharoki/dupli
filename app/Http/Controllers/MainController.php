<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Movies;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function movies(Request $request): JsonResponse
    {
        $movies = Movies::get();
        return response()->json($movies);
    }


    /**
     * @param Request $request
     * @param int $movie_id
     * @return JsonResponse
     */
    public function movie(Request $request, $movie_id): JsonResponse
    {
        $movie = Movies::with('rentedByUser')
            ->where('id', $movie_id)
            ->first();

        if(!$movie) {
            abort(404, 'movie not found');
        }

        return response()->json($movie);
    }
}
