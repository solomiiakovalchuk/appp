<div class="blog-post">
    <div class="blog-thumb">
        <img loading="lazy" src="{{ asset('storage/' .$post->cover_photo_path) }}" alt="{{ $post->photo_alt_text }}">
    </div>
    <div class="down-content">
        <div class="categories">
            @foreach ($post->categories as $category)
                <a href="{{ route('categories.posts', $category->slug) }}"><span
                        class="category-badge">{{ $category->title }}</span></a>
            @endforeach
        </div>
        <h4>{{ $post->title }}</h4>

        <ul class="post-info">
            <li>{{ $post->author->name ?? 'Admin' }}</li>
            <li>{{ $post->created_at->format('d-m-Y') }}</li>
            <li>{{ $post->comments_count }} Comments</li>
        </ul>
        {!! $post->body !!}
        <div class="post-options">
            <ul class="post-tags">
                <li><i class="fa fa-tags"></i></li>
                @foreach ($post->tags as $tag)
                    <li><a href="{{ route('tags.posts', $tag->slug) }}">{{ $tag->title }}, </a></li>
                @endforeach
            </ul>
            <a href="javascript:void(0)" class="like-button" data-post-id="{{ $post->id }}">
                <i class="fa fa-heart {{ $post->isLikedByUser() ? 'liked' : '' }}"></i>
            </a>
        </div>
    </div>
</div>
