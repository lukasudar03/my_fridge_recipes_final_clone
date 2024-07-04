<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fridge Recipes</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">My Fridge Recipes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?page=recipes">Recipes</a></li>
            <?php if (is_logged_in()): ?>
                <li class="nav-item"><a class="nav-link" href="index.php?page=my_fridge">My Fridge</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=profile">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=add_recipe">Add Recipe</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=favorites">My Favorites</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=menu">My Menus</a></li>
                <li class="nav-item"><a class="nav-link" href="templates/pages/logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="index.php?page=login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=register">Register</a></li>
            <?php endif; ?>
            <?php if (is_admin()): ?>
                <li class="nav-item"><a class="nav-link" href="index.php?page=admin_dashboard">Admin</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Include jQuery and Bootstrap JS at the end of the body to ensure the page loads quickly -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
