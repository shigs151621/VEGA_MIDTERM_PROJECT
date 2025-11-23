<x-layouts.app :title="__('Movie Lists')">
    <div class="space-y-6">

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-red-800 bg-gradient-to-b from-maroon-900 via-maroon-800 to-maroon-950 dark:border-red-900">
            <div class="flex h-full flex-col p-6">
                <!-- Add New Movie Form -->
                <div class="mb-6 rounded-lg border border-red-700 bg-maroon-800/70 p-6">
                    <h2 class="mb-4 text-lg font-semibold text-red-200">Add New Movie</h2>
                    
                    <form action="{{ route('movies.store') }}" method="POST" class="grid gap-4 md:grid-cols-2" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter movie name" required class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            @error('title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="mb-2 block text-sm font-medium text-red-300">Genre
                            <select id="edit_genre_id" name="genre_id" required
                                    class="w-full rounded-lg mt-2 border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                                <option value="">Select a genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Release Year</label>
                            <input type="year" name="release_year" value="{{ old('release_year') }}" placeholder="Enter release year" required class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            @error('release_year')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Language</label>
                            <input type="text" name="language" value="{{ old('language') }}" placeholder="Enter movie language" class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            @error('language')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Duration</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" placeholder="Enter movie duration" class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            @error('duration')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Director</label>
                            <input type="text" name="director" value="{{ old('director') }}" placeholder="Enter movie director" class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            @error('director')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">Description</label>
                            <textarea name="description" rows="1" placeholder="Enter description" class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-red-700 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                                Add Movie
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Movie List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-red-200">Movie List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-red-700 bg-maroon-800/70">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Movie Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Genre</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Release Year</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Language</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Duration</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Director</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-700">
                                @forelse($movies as $movie)
                                    <tr class="transition-colors hover:bg-maroon-700/50" id="movie-row-{{ $movie->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-red-300">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-100">{{ $movie->title }}</td>
                                        <td class="px-4 py-3 text-sm text-red-300">{{ $movie->genre ? $movie->genre->name : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-100">{{ $movie->release_year }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-100">{{ $movie->language }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-100">{{ $movie->duration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-100">{{ $movie->director }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-300">{{ Str::limit($movie->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editMovie(
                                                {{ $movie->id }},
                                                '{{ addslashes($movie->title) }}',
                                                '{{ $movie->genre_id }}',
                                                '{{ $movie->release_year }}',
                                                '{{ addslashes($movie->language) }}',
                                                '{{ addslashes($movie->duration) }}',
                                                '{{ addslashes($movie->director) }}',
                                                '{{ addslashes($movie->description) }}'
                                            );" class="text-red-400 transition-colors hover:text-red-500">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-red-700">|</span>
                                           <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this movie to trash?')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                              Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-sm text-red-300">
                                            No movies found. Add your first movie above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Edit Modal -->
<div id="editMovieModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[9999]">
    <div class="w-full max-w-2xl rounded-xl border border-red-700 bg-maroon-800 p-6">
        <h2 class="mb-4 text-lg font-semibold text-red-200">Edit Movie</h2>
        <form id="editMovieForm" method="POST">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Movie Name</label>
                    <input type="text" id="edit_movie_name" name="title"
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Genre</label>
                    <select id="edit_genre_select" name="genre_id" required
                        class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                        <option value="">Select a genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Release Year</label>
                    <input type="year" id="edit_release_year" name="release_year"
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Language</label>
                    <input type="text" id="edit_language" name="language"
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Duration</label>
                    <input type="text" id="edit_duration" name="duration"
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Director</label>
                    <input type="text" id="edit_director" name="director"
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-red-300">Description</label>
                    <textarea id="edit_description" name="description" rows="3"
                              class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-white focus:border-red-500 focus:ring-2 focus:ring-red-500/30"></textarea>
                </div>
            </div>
            <div class="md:col-span-2 mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-300 hover:bg-maroon-700">Cancel</button>
                <button type="submit" class="rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-800">Update Movie</button>
            </div>
        </form>
    </div>
</div>



    <script>
        function editMovie(id, name, genre_id, release_year, language, duration, director, description) {
            document.getElementById('editMovieModal').classList.remove('hidden');
            document.getElementById('editMovieModal').classList.add('flex');
            document.getElementById('editMovieForm').action = `/movies/${id}`;
            document.getElementById('edit_movie_name').value = name;
            document.getElementById('edit_genre_select').value = genre_id;
            document.getElementById('edit_release_year').value = release_year;
            document.getElementById('edit_language').value = language;
            document.getElementById('edit_duration').value = duration;
            document.getElementById('edit_director').value = director;
            document.getElementById('edit_description').value = description || '';
        }

        function closeEditModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
            document.getElementById('editMovieModal').classList.remove('flex');
            document.getElementById('editMovieForm').reset();
        }
    </script>
</x-layouts.app>
