<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            @foreach ($sliderPosts as $post)
                <div class="item">
                    <img loading="lazy" src="{{ asset('storage/' . $post->cover_photo_path) }}" alt="{{ $post->title }}">
                    <div class="item-content">
                        <!-- Dark overlay -->
                        <div class="overlay"></div>
                        <div class="main-content">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
