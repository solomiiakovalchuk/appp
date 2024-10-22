<div class="sidebar-item comments">
    <div class="sidebar-heading">
        <h2>{{ $comments->count() }} comments</h2>
    </div>
        <ul>
            @foreach ($comments as $comment)
                <li>
                    <div class="author-thumb">
                        <!-- <img src="{{ asset('images/comment-author-01.jpg') }}" alt=""> -->
                    </div>
                    <div class="right-content">
                        <h4>{{ $comment->user->name ?? 'Anonymous' }}<span>{{ $comment->created_at->format('M d, Y') }}</span></h4>
                        <p>{{ $comment->comment }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
</div>
