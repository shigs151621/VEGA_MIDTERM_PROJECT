<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class DashboardController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        $genres = Genre::all();

        return view('dashboard', compact('movies', 'genres'));
    }
}
