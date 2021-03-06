<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table = 'rents';
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function movie()
    {
        return $this->belongsTo(Movies::class);
    }

}
