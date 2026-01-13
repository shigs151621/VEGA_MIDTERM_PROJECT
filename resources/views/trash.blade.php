<x-layouts.app :title="__('Movie Trash')">
    <div class="space-y-6">

         {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-red-400">Movie Trash</h1>
                <p class="mt-1 text-sm text-red-300/70">
                    Restore or permanently delete movies
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-800">
                Back to Dashboard
            </a>
        </div>

        {{-- Summary Card --}}
        <div class="rounded-xl border border-red-700 bg-maroon-950 p-5 shadow-lg shadow-red-900/20">
            <p class="text-sm font-medium text-red-400">Movies in Trash</p>
            <p class="mt-1 text-3xl font-bold text-white">{{ $movies->count() }}</p>
        </div>

        {{-- Table Container --}}
        <div class="relative overflow-hidden rounded-xl border border-red-800 bg-gradient-to-b from-maroon-900 via-maroon-800 to-maroon-950">
            <div class="p-6">

                <h2 class="mb-4 text-lg font-semibold text-red-400">Deleted Movies</h2>

                @if($movies->isEmpty())
                    <div class="flex items-center justify-center rounded-lg border border-dashed border-red-700 p-12">
                        <div class="text-center">
                            <h3 class="text-sm font-medium text-red-300">Trash is empty</h3>
                            <p class="mt-1 text-sm text-red-400/70">No deleted movies found.</p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-red-700">
                        <table class="w-full text-left">
                            <thead class="bg-maroon-900/70 border-b border-red-700">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Poster</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Movie</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Genre</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Year</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Duration</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200">Deleted At</th>
                                    <th class="px-4 py-3 text-xs font-semibold text-red-200 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-red-700">
                                @foreach($movies as $movie)
                                    <tr class="transition-colors hover:bg-maroon-900/50">

                                        {{-- Poster --}}
                                        <td class="px-4 py-3">
                                            @if($movie->photo)
                                                <img
                                                    src="{{ Storage::url($movie->photo) }}"
                                                    class="h-10 w-10 rounded-full object-cover ring-2 ring-red-500/40"
                                                >
                                            @else
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full
                                                            bg-red-900/40 text-sm font-semibold text-red-300
                                                            ring-2 ring-red-700">
                                                    {{ strtoupper(substr($movie->title, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Title --}}
                                        <td class="px-4 py-3 text-sm font-medium text-white">
                                            {{ $movie->title }}
                                        </td>

                                        {{-- Genre --}}
                                        <td class="px-4 py-3 text-sm text-red-300">
                                            {{ $movie->genre?->name ?? 'N/A' }}
                                        </td>

                                        {{-- Year --}}
                                        <td class="px-4 py-3 text-sm text-white">
                                            {{ $movie->release_year }}
                                        </td>

                                        {{-- Duration --}}
                                        <td class="px-4 py-3 text-sm text-red-300">
                                            {{ $movie->duration ?? 'N/A' }}
                                        </td>

                                        {{-- Deleted At --}}
                                        <td class="px-4 py-3 text-sm text-red-400/70">
                                            {{ $movie->deleted_at->format('M d, Y') }}
                                            <div class="text-xs">
                                                {{ $movie->deleted_at->format('h:i A') }}
                                            </div>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3">
                                            <div class="flex justify-end gap-2">

                                                {{-- Restore --}}
                                                <form method="POST" action="{{ route('movies.restore', $movie->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Restore this movie?')"
                                                        class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-green-700">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Delete Forever --}}
                                                <form method="POST" action="{{ route('movies.force-delete', $movie->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Permanently delete this movie? This cannot be undone!')"
                                                        class="rounded-lg bg-red-700 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-800">
                                                        Delete Forever
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>