<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('genre');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('director', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('genre_filter') && $request->genre_filter != '') {
            $query->where('genre_id', $request->genre_filter);
        }

        $movies = $query->latest()->get();
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
            'duration' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('movies_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        Movie::create($validated);
        return redirect()->route('dashboard')->with('success', 'Movie added successfully!');
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string|max:1000',
            'release_year' => 'nullable|digits:4|integer',
            'duration' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($movie->photo) {
                Storage::disk('public')->delete($movie->photo);
            }

            $photoPath = $request->file('photo')->store('movies_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $movie->update($validated);
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.trash')->with('success', 'Movie deleted successfully!');
    }

    public function trash()
    {
        $movies = Movie::onlyTrashed()->with('genre')->latest('deleted_at')->get();
        $genres = Genre::all();

        return view('trash', compact('movies', 'genres'));
    }

    public function restore($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);
        $movie->restore();

        return redirect()->route('movies.index')->with('success', 'Movie restored successfully!');
    }

    public function forceDelete($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);

        if ($movie->photo) {
            Storage::disk('public')->delete($movie->photo);
        }

        $movie->forceDelete();

        return redirect()->route('movies.trash')->with('success', 'Movie permanently deleted!');
    }

    public function export (Request $request)
    {
        $query = Movie::with('genre');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('director', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('genre_filter') && $request->genre_filter != '') {
            $query->where('genre_id', $request->genre_filter);
        }

        $movie = $query->latest()->get();

        $filename = 'movies_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Movies Export</title>
            <style>
                body {
                    font-family: "Helvetica", Arial, sans-serif;
                    background: #fdf2f2; /* light red/pinkish */
                    margin: 0;
                    padding: 30px;
                    color: #4b0000;
                }

                .container {
                    max-width: 1100px;
                    margin: auto;
                    background: #ffffff;
                    padding: 32px;
                    border-radius: 8px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }

                .header h1 {
                    margin: 0;
                    font-size: 26px;
                    letter-spacing: 0.5px;
                    color: #b91c1c; /* strong red */
                }

                .header p {
                    margin-top: 8px;
                    font-size: 14px;
                    color: #991b1b;
                }

                .divider {
                    height: 2px;
                    background: #fca5a5; /* light red divider */
                    margin: 25px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }

                th {
                    background: #b91c1c; /* dark red header */
                    color: #ffffff;
                    padding: 12px 10px;
                    text-align: left;
                }

                td {
                    padding: 10px;
                    border-bottom: 1px solid #fca5a5;
                    vertical-align: top;
                }

                tr:nth-child(even) {
                    background: #fee2e2; /* light red even rows */
                }

                .badge {
                    display: inline-block;
                    padding: 4px 8px;
                    font-size: 12px;
                    border-radius: 12px;
                    background: #f87171; /* red badge */
                    color: #7f1d1d;
                    font-weight: 600;
                }

                .rating {
                    font-weight: bold;
                    color: #b45309; /* amber/dark yellow for ratings */
                }

                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 13px;
                    color: #7f1d1d;
                }

                @media print {
                    body {
                        background: white;
                        padding: 0;
                    }
                    .container {
                        border-radius: 0;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">

                <div class="header">
                    <h1>Movies Report</h1>
                    <p>
                        Exported on ' . date('F d, Y \\a\\t h:i A') . '<br>
                        Total Records: ' . $movie->count() . '
                    </p>
                </div>

                <div class="divider"></div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Movie Title</th>
                            <th>Genre</th>
                            <th>Release Year</th>
                            <th>Language</th>
                            <th>Director</th>
                            <th>Duration</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $number = 1;
                    foreach ($movie as $movie) {
                        $html .= '<tr>
                            <td>' . $number++ . '</td>
                            <td>' . htmlspecialchars($movie->title) . '</td>
                            <td>
                                <span class="badge">' . htmlspecialchars($movie->genre ? $movie->genre->name : 'No Genre') . '</span>
                            </td>
                            <td>' . htmlspecialchars($movie->release_year ?? '-') . '</td>
                            <td>' . htmlspecialchars($movie->language ?? '-') . '</td>
                            <td>' . htmlspecialchars($movie->director ?? '-') . '</td>
                            <td>' . htmlspecialchars($movie->duration ?? '-') . '</td>
                            <td>' . $movie->created_at->format('Y-m-d H:i:s') . '</td>
                        </tr>';
                    }

        $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Movies: ' . $movie->count() . '<br/>
                    © ' . date('Y') . ' MovieVault. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
    