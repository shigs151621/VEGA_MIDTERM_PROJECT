<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
     use hasFactory;
     use SoftDeletes;

     protected $fillable = [
        'title',
        'genre_id',
        'description',
        'release_year',
        'duration',
        'director',
        'language',
        'photo',
     ];

     public function genre()
     {
        return $this->belongsTo(Genre::class);
     }
}
