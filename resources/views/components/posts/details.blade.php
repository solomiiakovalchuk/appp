<div class="blog-post">
    <div class="blog-thumb">
        <img src="{{  asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}">
    </div>
    <div class="down-content">
        <span>{{ $post->category->name ?? 'Uncategorized' }}</span>
        <a href="{{ route('posts.show', $post->id) }}"><h4>{{ $post->title }}</h4></a>
        <ul class="post-info">
            <li><a href="#">{{ $post->author->name ?? 'Admin' }}</a></li>
            <li><a href="#">{{ $post->created_at->format('d-m-Y') }}</a></li>
            <li><a href="#">{{ $post->comments_count }} Comments</a></li>
        </ul>
        <p>{{ Str::limit($post->body, 150) }}</p>
        <div class="post-options">
            <div class="row">
                <div class="col-6">
                    <ul class="post-tags">
                        <li><i class="fa fa-tags"></i></li>
                    </ul>
                </div>
                <div class="col-6">
                    <ul class="post-share">
                        <li><i class="fa fa-share-alt"></i></li>
                        <li><a href="#">Facebook</a>,</li>
                        <li><a href="#"> Twitter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
