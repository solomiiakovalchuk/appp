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
            <button class="like-button" data-post-id="{{ $post->id }}">
                <i class="fa fa-heart {{ $post->isLikedByUser() ? 'liked' : '' }}"></i>
            </button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.like-button').on('click', function() {
            var postId = $(this).data('post-id');
            var button = $(this);

            $.ajax({
                url: '/post/' + postId + '/like',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Додаємо CSRF токен
                },
                success: function(response) {
                    if (response.status === 'liked') {
                        button.text('Unlike');
                    } else {
                        button.text('Like');
                    }
                }
            });
        });
    });
</script>
