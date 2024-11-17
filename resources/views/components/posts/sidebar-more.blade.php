@props(['tags'])
@props(['categories'])
@props(['recentPosts'])
<div class="col-lg-4">
    <div class="sidebar">
        <div class="row">
            <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                        <h2>{{ __('post.recent') }}</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach ($recentPosts as $post)
                                <li>
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        <h5>{{ $post->title }}</h5>
                                        <span>{{ $post->created_at->format('F d, Y') }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="sidebar-item tags">
                    <div class="sidebar-heading">
                        <h2>{{ __('post.tags') }}</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach ($tags as $tag)
                                <li><a href="{{ route('tags.posts', $tag->slug) }}">#{{ $tag->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

