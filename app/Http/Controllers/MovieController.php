<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();
        $genres = Genre::all();

        return view('movies', compact('movies', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'nullable|digits:4|integer',
            'language' => 'nullable|string|max:100',
        ]);

        Movie::create($validated);
        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:255',
            'genre_id' => 'required|exists:genres, id',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'nullable|digits:4|integer',
            'language' => 'nullable|string|max:100',
        ]);

        $movie->update($validated);
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->back()->with('success', 'Movie deleted successfully!');
    }
}
    