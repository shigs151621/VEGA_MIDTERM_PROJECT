<x-layouts.app :title="__('Genres')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200" x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-red-800 bg-gradient-to-b from-maroon-900 via-maroon-800 to-maroon-950">
            <div class="flex h-full flex-col p-6">

                <div class="mb-6 rounded-lg border border-red-700 bg-maroon-800/70 p-6">
                    <h2 class="mb-4 text-lg font-semibold text-red-200">Add New Genre</h2>

                    <form action="{{ route('genres.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-red-300">Genre Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       placeholder="Enter genre name" required
                                       class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-red-300">Description</label>
                                <textarea name="description" rows="1" placeholder="Enter genre description"
                                          class="w-full rounded-lg border border-red-600 bg-maroon-900 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-red-700 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500/40">
                                Add Genre
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Genre List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-red-200">Genre List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-red-700 bg-maroon-800/70">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Genre Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-red-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-700">
                                @forelse($genres as $genre)
                                    <tr class="transition-colors hover:bg-maroon-700/50" id="genre-row-{{ $genre->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-red-300">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-red-300">
                                            <span class="genre-name-display">{{ $genre->name }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-red-300">
                                            <span class="genre-description-display">{{ Str::limit($genre->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editGenre({{ $genre->id }}, '{{ addslashes($genre->name) }}', '{{ addslashes($genre->description) }}')"
                                                    class="text-red-400 transition-colors hover:text-red-500">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-red-700">|</span>
                                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this genre to trash?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn text-red-600 transition-colors hover:text-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-red-300">
                                            No genres found. Add your first genre above!
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

<!-- Edit Genre Modal -->
<div id="editGenreModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="w-full max-w-2xl rounded-xl border border-red-700 bg-gray-900 p-6">
        <h2 class="mb-4 text-lg font-semibold text-red-200">Edit Genre</h2>

        <form id="editGenreForm" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-red-300">Genre Name</label>
                    <input type="text" id="edit_genre_name" name="name" required
                           class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-red-300">Description</label>
                    <textarea id="edit_description" name="description" rows="3"
                              class="w-full rounded-lg border border-red-600 bg-gray-700 px-4 py-2 text-sm text-red-50 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/30"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-300 hover:bg-gray-800">
                    Cancel
                </button>
                <button type="submit" class="rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-800">
                    Update Genre
                </button>
            </div>
        </form>
    </div>
</div>



    <script>
        function editGenre(id, name, description) {
            document.getElementById('editGenreModal').classList.remove('hidden');
            document.getElementById('editGenreModal').classList.add('flex');
            document.getElementById('editGenreForm').action = `/genres/${id}`;

            document.getElementById('edit_genre_name').value = name;
            document.getElementById('edit_description').value = description || '';
        }

        function closeEditModal() {
            document.getElementById('editGenreModal').classList.add('hidden');
            document.getElementById('editGenreModal').classList.remove('flex');
            document.getElementById('editGenreForm').reset();
        }
    </script>
</x-layouts.app>
