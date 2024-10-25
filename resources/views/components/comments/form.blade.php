<div class="sidebar-item submit-comment">
    <div class="sidebar-heading">
        <h2 id="comment-heading" style="cursor: pointer;">Leave your comment</h2>
    </div>
    <div class="content" id="comment-form" style="display: none;">
        <form id="comment" method="post" action="{{ route('comments.store') }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ 2 }}">
            <div class="row">
                <div class="col-lg-12">
                    <fieldset>
                        <textarea name="message" rows="6" id="message" placeholder="Type your comment" required=""></textarea>
                    </fieldset>
                </div>
                <div class="col-lg-12">
                    <fieldset>
                        <button type="submit" id="form-submit" class="main-button">Submit</button>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</div>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const commentHeading = document.getElementById('comment-heading');
    const commentForm = document.getElementById('comment-form');
    const commentTextarea = document.getElementById('message');

    // Assume this variable is set by your backend
    const isLoggedIn = @json(auth()->check());

    function toggleCommentForm() {
        if (!isLoggedIn) {
            window.location.href = '{{ route("login") }}';
            return;
        }

        if (commentForm.style.display === 'none') {
            commentForm.style.display = 'block';
            commentHeading.textContent = 'Hide comment form';
        } else {
            commentForm.style.display = 'none';
            commentHeading.textContent = 'Your comment';
        }
    }

    commentHeading.addEventListener('click', toggleCommentForm);

    // AJAX submission for comments
    document.getElementById('comment').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicate it's an AJAX request
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                const commentList = document.getElementById('comment-list');
                const newComment = document.createElement('div');
                newComment.innerHTML = `
                    <p><strong>${data.user.name}:</strong> ${data.comment}</p>
                `;
                commentList.prepend(newComment);
                commentTextarea.value = '';
                Console.Log('ajax create comment')
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection
