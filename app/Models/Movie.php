<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
     use hasFactory;

     protected $fillable = [
        'title',
        'genre_id',
        'description',
        'release_year',
        'language',
     ];

     public function genre()
     {
        return $this->belongsTo(Genre::class);
     }
}
