@if ($paginator->hasPages())
    <div class="ui pagination menu clear-shadow">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="disabled item"><span>上一页</span></div>
        @else
            <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="disabled item">{{ $element }}</div>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active item">{{ $page }}</a>
                    @else
                        <a class="item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a>
        @else
            <div class="disabled item">下一页</div>
        @endif
    </div>
@endif
