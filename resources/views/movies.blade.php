<x-layouts.app :title="__('Movie Lists')">
    <div class="space-y-6">

         {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

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
                            <select id="genre_id" name="genre_id" required
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

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-red-300">
                                Movie Poster (Optional)
                            </label>

                            <input
                                type="file"
                                name="photo"
                                accept="image/jpeg,image/png,image/jpg"
                                class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-200
                                    file:mr-4 file:rounded-md file:border-0
                                    file:bg-red-700 file:px-4 file:py-2
                                    file:text-sm file:font-medium file:text-white
                                    hover:file:bg-red-800
                                    focus:border-red-500 focus:outline-none
                                    focus:ring-2 focus:ring-red-500/30"
                            >

                            <p class="mt-1 text-xs text-red-400">
                                JPG, PNG or JPEG. Max 2MB.
                            </p>

                            @error('photo')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-red-700 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                                Add Movie
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-xl border border-red-800 bg-gradient-to-b from-maroon-900 via-maroon-800 to-maroon-950 p-6">

                    {{-- Header + Export --}}
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-red-200">
                                Search & Filter Movies
                            </h2>
                            <p class="mt-1 text-sm text-red-300/70">
                                Find movies by title or genre
                            </p>
                        </div>

                        <form method="GET" action="{{ route('movies.export') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="genre_filter" value="{{ request('genre_filter') }}">

                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg
                                    bg-green-600 px-4 py-2 text-sm font-medium text-white
                                    transition hover:bg-green-700
                                    focus:ring-2 focus:ring-green-500/40">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export PDF
                            </button>
                        </form>
                    </div>

                    {{-- Filters --}}
                    <form action="{{ route('movies.index') }}" method="GET"
                        class="grid gap-4 md:grid-cols-3">

                        {{-- Search --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">
                                Search Movie
                            </label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by movie name"
                                class="w-full rounded-lg border border-red-600 bg-maroon-900
                                    px-4 py-2 text-sm text-red-50 placeholder-red-400
                                    focus:border-red-500 focus:outline-none
                                    focus:ring-2 focus:ring-red-500/30"
                            >
                        </div>

                        {{-- Genre --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-red-300">
                                Filter by Genre
                            </label>
                            <select
                                name="genre_filter"
                                class="w-full rounded-lg border border-red-600 bg-maroon-900
                                    px-4 py-2 text-sm text-red-50
                                    focus:border-red-500 focus:outline-none
                                    focus:ring-2 focus:ring-red-500/30"
                            >
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ request('genre_filter') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-end gap-2">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-red-700 px-4 py-2
                                    text-sm font-medium text-white
                                    transition hover:bg-red-800
                                    focus:ring-2 focus:ring-red-500/40">
                                Apply
                            </button>

                            <a
                                href="{{ route('movies.index') }}"
                                class="rounded-lg border border-red-600 px-4 py-2
                                    text-sm font-medium text-red-300
                                    transition hover:bg-maroon-700 hover:text-white">
                                Clear
                            </a>
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
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Poster</th>
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
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50" id="movie-row-{{ $movie->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            @if($movie->photo)
                                                <img
                                                    src="{{ Storage::url($movie->photo) }}"
                                                    alt="{{ $movie->title }}"
                                                    class="h-12 w-12 rounded-full object-cover
                                                        ring-2 ring-red-500/40"
                                                >
                                            @else
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-full
                                                        bg-red-900/40 text-sm font-semibold text-red-300
                                                        ring-2 ring-red-700"
                                                >
                                                    {{ strtoupper(substr($movie->title, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-name-display">{{ $movie->title }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $movie->genre ? $movie->genre->name : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-year-display">{{ $movie->release_year }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-language-display">{{ $movie->language }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-duration-display">{{ $movie->duration }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-director-display">{{ $movie->director }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-red-300">{{ Str::limit($movie->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editMovie(
                                                '{{ $movie->id }}',
                                                '{{ addslashes($movie->title) }}',
                                                '{{ $movie->genre_id }}',
                                                '{{ $movie->release_year }}',
                                                '{{ $movie->language }}',
                                                '{{ $movie->duration }}',
                                                '{{ $movie->director }}',
                                                '{{ addslashes($movie->description) }}',
                                                '{{ $movie->photo }}',
                                            );" class="text-red-400 transition-colors hover:text-red-500">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-red-700">|</span>
                                           <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this movie to trash?')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="delete-btn text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                              Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-4 py-8 text-center text-sm text-red-300">
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
    <div class="w-full max-w-2xl rounded-xl border border-red-700 bg-gray-900 p-6">
        <h2 class="mb-4 text-lg font-semibold text-red-200">Edit Movie</h2>
        <form id="editMovieForm" method="POST" enctype="multipart/form-data">
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
                <!-- Current Poster Preview -->
                <div id="currentPhotoPreview" class="mb-3"></div>

                    <input
                        type="file"
                        id="edit_photo"
                        name="photo"
                        accept="image/jpeg,image/png,image/jpg"
                        class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-200
                            file:mr-4 file:rounded-md file:border-0
                            file:bg-red-700 file:px-4 file:py-2
                            file:text-sm file:font-medium file:text-white
                            hover:file:bg-red-800
                            focus:border-red-500 focus:outline-none
                            focus:ring-2 focus:ring-red-500/30"
                    >

                    <p class="mt-1 text-xs text-red-400">
                        Leave empty to keep current poster. JPG, PNG or JPEG. Max 2MB.
                    </p>
                </div>
            <div class="md:col-span-2 mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-300 hover:bg-maroon-700">Cancel</button>
                <button type="submit" class="rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-800">Update Movie</button>
            </div>
        </form>
    </div>
</div>



    <script>
        function editMovie(id, name, genre_id, release_year, language, duration, director, description, photo) {
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
            const photoPreview = document.getElementById('currentPhotoPreview');
            if (photo) {
                photoPreview.innerHTML = `
                    <div class="flex items-center gap-3 rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                        <img src="/storage/${photo}" alt="${name}" class="h-16 w-16 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Current Photo</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload new photo to replace</p>
                        </div>
                    </div>
                `;
            } else {
                photoPreview.innerHTML = `
                    <div class="rounded-lg border border-dashed border-neutral-300 p-4 text-center dark:border-neutral-600">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No photo uploaded</p>
                    </div>
                `;
            }
        }

        function closeEditModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
            document.getElementById('editMovieModal').classList.remove('flex');
            document.getElementById('editMovieForm').reset();
        }
    </script>
</x-layouts.app>
