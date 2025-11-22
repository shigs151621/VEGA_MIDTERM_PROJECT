<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;


class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::latest()->get();
        return view('genres', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|max:1000',
        ]);

        Genre::create($validated);
        return redirect()->back()->with('success', 'Genre added successfully!');
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $genre->update($validated);
        return redirect()->route('genres.store')->with('success', 'Genre updarte succesfully!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->back()->with('success', 'Genre deleted successfully!');
    }

    
}
