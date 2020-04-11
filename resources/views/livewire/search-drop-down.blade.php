<div class="relative mt-3 md:mt-0" x-data="{ open: true }" @click.away="open = false">
    <input
        wire:model.debounce.500ms="search"
        type="text"
        class="bg-gray-800 text-sm rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline"
        placeholder="Search"
        x-ref="search"
        @keydown.window="
            if (event.keyCode === 191) {
                event.preventDefault();
                $refs.search.focus();
            }
        "
        @focus="open = true"
        @keydown="open = true"
        @keydown.escape.window="open = false"
        @keydown.shift.tab="open = false"
    >

    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24">
            <path class="heroicon-ui"
                d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/>
        </svg>
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>

    @if (strlen($search) >= 3)
        <div
            class="absolute bg-gray-800 text-sm rounded w-64 mt-4 z-50"
            x-show.transition.opacity="open"
            @keydown.escape.window="open = false"
        >
            @if (isset($searchedMovies['results']) && count($searchedMovies['results']) > 0)
                <ul>
                    @foreach ($searchedMovies['results'] as $result)
                        <li class="border-b border-gray-700">
                            <a
                                href="{{ route('movies.show', $result['id']) }}"
                                class="block hover:bg-gray-700 px-3 py-3 flex items-center"
                                @if ($loop->iteration === 6) @keydown.tab="open = false" @endif
                            >
                                @php
                                    $poster_image = isset($result['poster_path']) ? 'https://image.tmdb.org/t/p/w92' . $result['poster_path'] : 'https://via.placeholder.com/50x75.jpg';
                                @endphp
                                <img src="{{ $poster_image }}" alt="{{ 'poster-' . Str::slug($result['title']) }}" class="w-8">
                                <span class="ml-4">{{ $result['title'] }}</span>
                            </a>
                        </li>

                        @break($loop->iteration === 6)
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">No results for {{ $search }}</div>
            @endif
        </div>
    @endif
</div>
