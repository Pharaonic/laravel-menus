<ul>
    @foreach($section as $item)
        <li><a href="{{ $item->url }}">{!! $item->title !!}</a></li>
    @endforeach
</ul>
