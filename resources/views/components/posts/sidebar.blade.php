@props(['tags'])
@props(['recentPosts'])
<div class="col-lg-4">
    <div class="sidebar">
        <div class="row">
            <div class="col-lg-12">
                <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="{{ route('search') }}">
                        <input type="text" id="searchInput" name="query" class="searchText" placeholder="type to search..."
                               autocomplete="on" data-locale="{{ app()->getLocale() }}">

                        <div id="searchResults" class="search-results"></div>
                        <input type="hidden" id="requestType" name="requestType" value="api">
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                        <h2>Recent Posts</h2>
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
                        <h2>Tags</h2>
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

