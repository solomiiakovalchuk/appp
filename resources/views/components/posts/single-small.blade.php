<div class="col-lg-6">
    <div class="blog-post">
        <div class="blog-thumb">
            <img loading="lazy" src="{{ asset($post->cover_photo_path) }}" alt="{{ $post->title }}">
        </div>
        <div class="down-content">
            @foreach ($post->categories as $category)
                <span><a href="{{ route('categories.posts', $category->slug) }}">{{ $category->title }}</a></span>
            @endforeach
            <a href="{{ route('posts.show', $post->slug) }}">
                <h4>{{ $post->title }}</h4>
            </a>
            <ul class="post-info">
                <li><a href="#">{{ $post->author->name ?? 'Admin' }}</a></li>
                <li><a href="#">{{ $post->created_at->format('d-m-Y') }}</a></li>
                <li><a href="#">12 Comments</a></li>
            </ul>
            <p>{{ Str::limit($post->body, 50) }}</p>
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
</div>
