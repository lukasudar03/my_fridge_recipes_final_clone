<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/comment.php';
require_once __DIR__ . '/../../utils/session.php';

require_login();
require_admin();

$approved_comments = Comment::get_approved_comments();
$unapproved_comments = Comment::get_unapproved_comments();
?>

<div class="container">
    <h1>Manage Comments</h1>
    <h2>Approved Comments</h2>
    <ul id="approved-comments-list">
        <?php foreach ($approved_comments as $comment): ?>
            <li>
                <?php echo htmlspecialchars($comment['content']); ?>
                <button class="btn btn-danger reject-comment-btn" data-comment-id="<?php echo $comment['id']; ?>">Reject</button>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Unapproved Comments</h2>
    <ul id="unapproved-comments-list">
        <?php foreach ($unapproved_comments as $comment): ?>
            <li>
                <?php echo htmlspecialchars($comment['content']); ?>
                <button class="btn btn-success approve-comment-btn" data-comment-id="<?php echo $comment['id']; ?>">Approve</button>
                <button class="btn btn-danger reject-comment-btn" data-comment-id="<?php echo $comment['id']; ?>">Reject</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.querySelectorAll('.approve-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const formData = new FormData();
            formData.append('action', 'approve_comment');
            formData.append('id', commentId);

            fetch('controllers/comment_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Comment approved successfully!');
                        location.reload();
                    } else {
                        alert('Failed to approve comment. ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });

    document.querySelectorAll('.reject-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const reason = prompt('Enter reason for rejection:');
            if (reason) {
                const formData = new FormData();
                formData.append('action', 'reject_comment');
                formData.append('id', commentId);
                formData.append('reason', reason);

                fetch('controllers/comment_controller.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Comment rejected successfully!');
                            location.reload();
                        } else {
                            alert('Failed to reject comment. ' + (data.message || ''));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });
    });
</script>
