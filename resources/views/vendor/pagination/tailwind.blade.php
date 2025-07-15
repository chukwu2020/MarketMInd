@if ($paginator->hasPages())
<div class="flex items-center justify-between flex-wrap gap-2 mt-6">
    <span>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</span>
    <ul class="pagination flex flex-wrap items-center gap-2 justify-center">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item">
            <span class="page-link bg-neutral-300 dark:bg-neutral-600 text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8 text-base opacity-50 cursor-not-allowed">
                <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
            </span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link bg-neutral-300 dark:bg-neutral-600 text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8 text-base"
                href="{{ $paginator->previousPageUrl() }}">
                <iconify-icon icon="ep:d-arrow-left"></iconify-icon>
            </a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="page-item"><span class="page-link">{{ $element }}</span></li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item">
            <a class="page-link text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8 text-base bg-primary-600 text-white"
                href="javascript:void(0)">{{ $page }}</a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link bg-neutral-300 dark:bg-neutral-600 text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8"
                href="{{ $url }}">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link bg-neutral-300 dark:bg-neutral-600 text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8 text-base"
                href="{{ $paginator->nextPageUrl() }}">
                <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
            </a>
        </li>
        @else
        <li class="page-item">
            <span class="page-link bg-neutral-300 dark:bg-neutral-600 text-secondary-light font-semibold rounded-lg border-0 flex items-center justify-center h-8 w-8 text-base opacity-50 cursor-not-allowed">
                <iconify-icon icon="ep:d-arrow-right"></iconify-icon>
            </span>
        </li>
        @endif

    </ul>
</div>
@endif