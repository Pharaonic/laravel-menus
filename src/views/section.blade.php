<ul>
    @foreach($section as $item)
        <li>
            <a href="{{ $item->url }}">{!! $item->translateOrDefault()->title ?? null !!}</a>
            @if($item->children->isNotEmpty())
                <ul>
                    @foreach($item->children as $sub)
                        <li><a href="{{ $sub->url }}">{!! $sub->translateOrDefault()->title ?? null !!}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
