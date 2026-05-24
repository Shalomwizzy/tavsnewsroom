<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>{{ htmlspecialchars($siteName) }}</title>
        <link>{{ url('/') }}</link>
        <description>{{ htmlspecialchars($description) }}</description>
        <language>en-us</language>
        <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
        <atom:link href="{{ route('rss') }}" rel="self" type="application/rss+xml"/>
        @foreach ($posts as $post)
        <item>
            <title>{{ htmlspecialchars($post->headline) }}</title>
            <link>{{ route('post-news.read-more', [
                'year'  => \Carbon\Carbon::parse($post->date)->format('Y'),
                'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                'day'   => \Carbon\Carbon::parse($post->date)->format('d'),
                'slug'  => $post->slug,
            ]) }}</link>
            <guid isPermaLink="true">{{ route('post-news.read-more', [
                'year'  => \Carbon\Carbon::parse($post->date)->format('Y'),
                'month' => \Carbon\Carbon::parse($post->date)->format('m'),
                'day'   => \Carbon\Carbon::parse($post->date)->format('d'),
                'slug'  => $post->slug,
            ]) }}</guid>
            <description>{{ htmlspecialchars(Str::limit(strip_tags($post->content), 300)) }}</description>
            <pubDate>{{ \Carbon\Carbon::parse($post->date)->toRfc2822String() }}</pubDate>
            <category>{{ htmlspecialchars($post->category->name ?? '') }}</category>
            @if ($post->image_url)
            <media:content url="{{ asset($post->image_url) }}" medium="image"/>
            @endif
        </item>
        @endforeach
    </channel>
</rss>
