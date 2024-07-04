<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <?php if (isset($_GET['token'])):?>
        <h1>Reset Password</h1>
        <form action="controllers/auth_controller.php" method="post">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="conf_pwd">Confirm password</label>
                <input type="password" id="conf_pwd" name="conf_pwd" class="form-control" required>
            </div>
            <input type="hidden" value="<?=$_GET['token'] ?>" name="token">
            <button type="submit" class="btn btn-primary" name="reset_password">Reset Password</button>
        </form>
    <?php else:?>
        <h1>Reset Password</h1>
        <form action="controllers/auth_controller.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="reset_password">Reset Password</button>
        </form>
    <?php endif;?>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
