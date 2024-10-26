<div class="col-lg-12">
    <div class="blog-post">
        <div class="blog-thumb">
            <img loading="lazy" src="{{ asset($post->cover_photo_path) }}" alt="">
        </div>
        <div class="down-content">
            <div class="categories">
                @foreach ($post->categories as $category)
                    <a href=""><span class="category-badge">{{ $category->title }}</span></a>
                @endforeach
            </div>

            <a href="{{ route('posts.show', $post->slug) }}">
                <h4>{{ $post->title }}</h4>
            </a>

            <ul class="post-info">
                <li><a href="#">{{ $post->author ?? 'Admin' }}</a></li>
                <li><a href="#">{{ $post->created_at->format('F d, Y') }}</a></li>
                <li><a href="#">{{ $post->comments->count() }} Comments</a></li>
            </ul>

            <p>{{ $post->short_description }}</p>

            <div class="post-options">
                <ul class="post-tags">
                    @foreach ($post->tags as $tag)
                        <li><a href="/">#{{ $tag->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
