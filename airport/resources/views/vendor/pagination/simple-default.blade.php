@if ($paginator->hasPages())
    <div class="simple page center-block">
        <div class="ui pagination menu clear-shadow">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <div class="disabled item"><span>上一页</span></div>
            @else
                <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a>
            @else
                <div class="disabled item"><span>下一页</span></div>
            @endif
        </div>
    </div>
@endif
