<x-layouts.app :title="__('Dashboard')">
    <div class="relative min-h-screen bg-black text-white overflow-hidden" 
         style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover; background-position: center;">
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
    </div>
</x-layouts.app>
