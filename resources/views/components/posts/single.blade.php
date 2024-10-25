<div class="col-lg-12">
    <div class="blog-post">
        <div class="blog-thumb">
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="">
        </div>
        <div class="down-content">
            @foreach ($post->categories as $category)
                <span>{{ $category->title }}</span>
            @endforeach

            <a href="{{ route('posts.show', $post->slug) }}"><h4>{{ $post->title }}</h4></a>
            <ul class="post-info">
                <li><a href="#">{{ $post->author ?? 'Admin' }}</a></li>
                <li><a href="#">{{ $post->created_at }}</a></li>
                <li><a href="#">{{ $post->comments->count() }} Comments</a></li>
            </ul>
            <p>{{ $post->short_description }}</p>
        </div>
    </div>
</div>
