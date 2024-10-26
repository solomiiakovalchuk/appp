<div class="blog-post">
    <div class="blog-thumb">
        <img loading="lazy" src="{{ asset($post->cover_photo_path) }}" alt="{{ $post->photo_alt_text }}">
    </div>
    <div class="down-content">
        <div class="categories">
            @foreach ($post->categories as $category)
                <a href=""><span class="category-badge">{{ $category->title }}</span></a>
            @endforeach
        </div>
        <h4>{{ $post->title }}</h4>

        <ul class="post-info">
            <li>{{ $post->author->name ?? 'Admin' }}</li>
            <li>{{ $post->created_at->format('d-m-Y') }}</li>
            <li>{{ $post->comments_count }} Comments</li>
        </ul>
        <p>{{ $post->body }}</p>
        <div class="post-options">
            <ul class="post-tags">
                @foreach ($post->tags as $tag)
                    <li><a href="/">#{{ $tag->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
