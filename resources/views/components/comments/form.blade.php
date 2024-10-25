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
        const isLoggedIn = @json(auth()->check());
        const commentCountElement = document.querySelector('.sidebar-heading h2'); // Лічильник коментарів

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
                commentHeading.textContent = 'Leave your comment';
            }
        }

        commentHeading.addEventListener('click', toggleCommentForm);

        document.getElementById('comment').addEventListener('submit', function (e) {
            e.preventDefault(); // Запобігти стандартній відправці форми

            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Позначити, що це AJAX-запит
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentList = document.querySelector('.sidebar-item.comments ul');
                        const newComment = document.createElement('li');

                        newComment.innerHTML = `
                    <div class="author-thumb">
                        <!-- Optionally, add the user's image here if available -->
                    </div>
                    <div class="right-content">
                        <h4>${data.user.name}<span>${data.comment.created_at}</span></h4>
                        <p>${data.comment.message}</p>
                    </div>
                `;

                        // Додати новий коментар на початок списку
                        commentList.prepend(newComment);

                        // Очистити поле тексту
                        commentTextarea.value = '';

                        // Оновити лічильник коментарів
                        const currentCount = parseInt(commentCountElement.textContent) || 0;
                        commentCountElement.textContent = `${currentCount + 1} comments`;
                        commentAlert = document.getElementById('comment-alert');
                        commentAlert.style.display = 'block';
                        setTimeout(() => {
                            commentAlert.style.display = 'none';
                        }, 3000);
                    } else {
                        console.error('Error in creating comment:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });


</script>
@endsection
