<x-layouts.app :title="__('Dashboard')">
    <div class="relative min-h-screen bg-black text-white overflow-hidden" 
         style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center;">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        {{-- Dashboard Cards --}}
        <div class="space-y-6 p-8 relative z-10">
            <div class="grid gap-10 md:grid-cols-3">
                <a href="{{ route('movies.index') }}">
                    <div class="flex items-center gap-6 rounded-3xl bg-black/60 border border-[#4d0a0a] p-10 shadow-2xl hover:scale-[1.03] transition transform hover:shadow-[#b30030]/50">
                        <div class="text-[#b30030] text-4xl">🎥</div>
                        <div>
                            <p class="text-sm text-gray-300">Total Movies</p>
                            <h3 class="text-4xl font-extrabold text-white">{{ $movies->count() }}</h3>
                        </div>
                    </div>
                </a>
                <a href="{{ route('genres.index') }}">
                    <div class="flex items-center gap-6 rounded-3xl bg-black/60 border border-[#4d0a0a] p-10 shadow-2xl hover:scale-[1.03] transition transform hover:shadow-[#b30030]/50">
                        <div class="text-[#b30030] text-4xl">🎞️</div>
                        <div>
                            <p class="text-sm text-gray-300">Total Genres</p>
                            <h3 class="text-4xl font-extrabold text-white">{{ $genres->count() }}</h3>
                        </div>
                    </div>
                </a>
                <a href="{{ route('movies.index') }}">
                    <div class="flex items-center gap-6 rounded-3xl bg-black/60 border border-[#4d0a0a] p-10 shadow-2xl hover:scale-[1.03] transition transform hover:shadow-[#b30030]/50">
                        <div class="text-[#b30030] text-4xl">🌙</div>
                        <div>
                            <p class="text-sm text-gray-300">Most Viewed</p>
                            <h3 class="text-2xl font-bold text-white">Just One Night</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="rounded-xl border border-red-800 bg-black/60 p-8 mx-10">
            <h2 class="mb-4 text-lg font-semibold text-red-200">
                Search & Filter Movies
            </h2>

            <form action="{{ route('dashboard') }}" method="GET" class="grid gap-4 md:grid-cols-3">

                <!-- Search -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">
                        Search Movie
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by movie name"
                        class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50
                            focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30"
                    >
                </div>

                <!-- Genre Filter -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">
                        Filter by Genre
                    </label>
                    <select
                        name="genre_filter"
                        class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50
                            focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30"
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

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white
                            transition-colors hover:bg-red-800 focus:ring-2 focus:ring-red-500/40"
                    >
                        Apply
                    </button>

                    <a
                        href="{{ route('dashboard') }}"
                        class="rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-300
                            transition-colors hover:bg-maroon-700 hover:text-white"
                    >
                        Clear
                    </a>
                </div>

            </form>
        </div>

        {{-- Movies by Genre --}}
        <div class="space-y-12 px-8 mt-10">

            @foreach($genres as $genre)
                @php
                    $genreMovies = $movies->where('genre_id', $genre->id);
                @endphp

                <section class="space-y-4">

                    {{-- GENRE LABEL --}}
                    <div class="inline-flex items-center gap-2 rounded-full
                                bg-red-700 px-6 py-2 text-sm font-semibold text-white
                                hover:bg-red-800 transition">
                        {{ $genre->name }} 🎬
                    </div>

                    {{-- GENRE MOVIES ROW --}}
                    @if($genreMovies->isEmpty())
                        <p class="text-red-400 ml-2">
                            No movies available for this genre.
                        </p>
                    @else
                        <div class="flex gap-5 overflow-x-auto pb-6 px-1">
                            @foreach($genreMovies as $movie)
                                <div x-data="{ open: false }"
                                    class="flex-shrink-0 w-64 md:w-80 rounded-xl border border-red-700
                                           overflow-hidden cursor-pointer shadow-lg bg-maroon-950">

                                    {{-- MOVIE POSTER --}}
                                    <div class="relative aspect-video" @click="open = true">
                                        @if($movie->photo)
                                            <img src="{{ asset('storage/' . $movie->photo) }}"
                                                alt="{{ $movie->title }}"
                                                class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center
                                                        bg-maroon-900 text-red-400">
                                                No Poster
                                            </div>
                                        @endif
                                    </div>

                                    {{-- TITLE --}}
                                    <div class="p-3 bg-black/60" @click="open = true">
                                        <h3 class="text-md flex justify-center font-medium text-red-300">
                                            {{ $movie->title }}
                                        </h3>
                                    </div>

                                    {{-- MODAL --}}
                                    <div x-show="open"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
                                        x-transition.opacity>

                                        <div class="bg-maroon-900 rounded-xl shadow-lg max-w-4xl w-full mx-4 md:mx-0 flex overflow-hidden border border-red-700">

                                            {{-- Left: Full Poster --}}
                                            <div class="w-1/2 hidden md:block">
                                                @if($movie->photo)
                                                    <img src="{{ asset('storage/' . $movie->photo) }}"
                                                        alt="{{ $movie->title }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div class="flex items-center justify-center w-full h-full bg-maroon-800 text-red-400">
                                                        No Poster
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Right: Movie Details --}}
                                            <div class="w-full md:w-1/2 p-6 flex flex-col justify-center space-y-2 bg-black/80">
                                                <h2 class="text-2xl font-bold text-red-300 mb-2">
                                                    {{ $movie->title }}
                                                </h2>

                                                <p class="text-red-200"><strong>Genre:</strong> {{ $genre->name }}</p>
                                                <p class="text-red-200"><strong>Release Year:</strong> {{ $movie->release_year ?? 'N/A' }}</p>
                                                <p class="text-red-200"><strong>Language:</strong> {{ $movie->language ?? 'N/A' }}</p>
                                                <p class="text-red-200"><strong>Director:</strong> {{ $movie->director ?? 'N/A' }}</p>
                                                <p class="text-red-200"><strong>Duration:</strong> {{ $movie->duration ?? 'N/A' }}</p>

                                                {{-- Close Button --}}
                                                <button
                                                    @click="open = false"
                                                    class="mt-4 px-4 py-2 bg-red-700 text-white rounded
                                                        transition self-end hover:bg-red-800">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                </section>
            @endforeach

        </div>

    </div>
</x-layouts.app>
