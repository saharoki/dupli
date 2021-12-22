<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    protected $table = 'movies';
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function rentedByUser()
    {
        $user = auth()->user();
        return $this->hasOne(Rent::class, 'movie_id', 'id')
            ->where([
                ['user_id', 1],
                ['rent_end', '>=', date('Y-m-d')],
            ]);
           // ->where('user_id', $user->id);
    }
}
