<?php include __DIR__ . '/../partials/header.php'; ?>
<!--<div class="container">-->
<!--    <h1>Login</h1>-->
<!--    <form action="controllers/auth_controller.php" method="post">-->
<!--        <div class="form-group">-->
<!--            <label for="email">Email</label>-->
<!--            <input type="email" id="email" name="email" class="form-control" required>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="password">Password</label>-->
<!--            <input type="password" id="password" name="password" class="form-control" required>-->
<!--        </div>-->
<!--        <button type="submit" class="btn btn-primary" name="login">Login</button>-->
<!--    </form>-->
<!--</div>-->

<?php if (isset($_GET['error'])): ?>
    <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>
<div class="container">
    <h1>Login</h1>
        <form method="POST" action="controllers/auth_controller.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <a href="index.php?page=forgotten_password" class="btn btn-primary">Forgot Password</a><br>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
