@if ($paginator->hasPages())
    <nav class="flex items-center justify-end" role="navigation" aria-label="Pagination">
        <ul class="inline-flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded">Prev</li>
            @else
                <li>
                    <a class="px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200" href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a>
                </li>
            @endif

            {{-- Pagination Elements (show only 2 numbers) --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $pages = [$current];
                if ($current < $last) {
                    $pages[] = $current + 1;
                } elseif ($current > 1) {
                    $pages[] = $current - 1;
                    $pages = array_unique($pages);
                    sort($pages);
                }
            @endphp

            @foreach ($pages as $page)
                @if ($page == $current)
                    <li class="px-3 py-2 text-sm text-white bg-blue-600 rounded">{{ $page }}</li>
                @else
                    <li>
                        <a class="px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="px-3 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded">Next</li>
            @endif
        </ul>
    </nav>
@endif
