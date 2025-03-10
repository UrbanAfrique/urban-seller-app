@if ($paginator->hasPages())
    <div class="w3-bar">
        @php
            $currentPage = $paginator->currentPage();
            $query = request()->query('s') ? '?s=' . request()->query('s') : '';
        @endphp
        @for ($page = 1; $page <= $paginator->lastPage(); $page++)
            <a class="w3-button w3-margin-left  {{ ($page == $currentPage) ? 'w3-black w3-disabled' : 'w3-light-gray' }}" href="{{ $route . $query . '&page=' . $page }}">{{ $page }}</a>
        @endfor
    </div>
@endif
