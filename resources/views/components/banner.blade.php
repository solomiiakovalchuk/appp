<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            @foreach ($sliderPosts as $post)
                <div class="item">
                    <img loading="lazy" src="{{ asset('storage/' . $post->cover_photo_path) }}" alt="{{ $post->title }}">
                    <div class="item-content">
                        <div class="main-content">
                            <a href="{{ route('posts.show', $post->slug) }}"><h4>{{ $post->title }}</h4></a>
                            <ul class="post-info">
                                <li><a href="#">{{ $post->author->name ?? 'Admin' }}</a></li>
                                <li><a href="#">{{ $post->created_at->format('F d, Y') }}</a></li>
                                <li><a href="#">{{ $post->comments_count }} Comments</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
