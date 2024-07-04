<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_login(); ?>
<div class="container">
    <h1>Profile</h1>
    <form id="profile-form" action="controllers/edit_user_controller.php" method="post" class="profile-form">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($_SESSION['first_name']); ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($_SESSION['last_name']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="number" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($_SESSION['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
            <small class="form-text text-muted">Leave blank to keep the current password.</small>
        </div>
        <button type="submit" class="btn btn-primary" name="action" value="update_profile">Update Profile</button>
    </form>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.profile-form').addEventListener('submit', (e) => {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData();

            // Append only non-empty fields
            const firstName = form.querySelector('#first_name').value.trim();
            if (firstName) formData.append('first_name', firstName);

            const lastName = form.querySelector('#last_name').value.trim();
            if (lastName) formData.append('last_name', lastName);

            const phone = form.querySelector('#phone').value.trim();
            if (phone) formData.append('phone', phone);

            const password = form.querySelector('#password').value.trim();
            if (password) formData.append('password', password);

            formData.append('action', 'update_profile');

            fetch('controllers/edit_user_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully.');
                        location.reload();
                    } else {
                        alert('Profile update failed. ' + (data.message || ''));
                    }
                });
        });
    });
</script>
