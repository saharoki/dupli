<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Movies;
use App\Models\Rent;

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

        if(!is_null($movie->rented_by_user)){
            $movie->rented_by_user->days->left = $movie->rented_by_user->rent_end->diff(new \DateTime())->days;
        }

        return response()->json($movie);
    }

    public function rent_movie(Request $request, $movie_id)
    {
        //$user = auth()->user();
        $user = new \StdClass();
        $user->id = 1;
        $today = date('Y-m-d');

        $rented = Rent::where([
            ['user_id', $user->id],
            ['movie_id', $movie_id],
            ['rent_end', '>=', $today],
            ])->first();

        if($rented){
            $days =$rented->rent_end->diff(new \DateTime())->days;
            return response()->json(['rent_end' => $days]);
        }

        //check if movie exists
        $movie = Movies::where('id', $movie_id)->first();
        if(!$movie){
            abort(404, 'movie not found');
        }

        $next_week = $date = strtotime("+7 day");

        $rented = new Rent();
        $rented->user_id = $user->id;
        $rented->movie_id = $movie_id;
        $rented->rent_start = $today;
        $rented->rent_end = date('Y-m-d', $next_week);
        $rented->save();
        return response()->json(['rent_end'=> 7]);
    }
}
