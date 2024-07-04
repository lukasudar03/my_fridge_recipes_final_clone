<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../utils/session.php';

require_login();
require_admin();

$blocked_users = User::get_all_blocked_users();
$unblocked_users = User::get_all_unblocked_users();
?>

<div class="container">
    <h1>Manage Users</h1>
    <h2>Blocked Users</h2>
    <ul id="blocked-users-list">
        <?php foreach ($blocked_users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['email']); ?>
                <button class="btn btn-success unblock-user-btn" data-user-id="<?php echo $user['id']; ?>">Unblock</button>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Users</h2>
    <ul id="users-list">
        <?php foreach ($unblocked_users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['email']); ?>
                <button class="btn btn-danger block-user-btn" data-user-id="<?php echo $user['id']; ?>">Block</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.querySelectorAll('.unblock-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const formData = new FormData();
            formData.append('action', 'unblock_user');
            formData.append('id', userId);

            fetch('controllers/user_admin_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User unblocked successfully!');
                        location.reload();
                    } else {
                        alert('Failed to unblock user. ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });

    document.querySelectorAll('.block-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const formData = new FormData();
            formData.append('action', 'block_user');
            formData.append('id', userId);

            fetch('controllers/user_admin_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User blocked successfully!');
                        location.reload();
                    } else {
                        alert('Failed to block user. ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>
