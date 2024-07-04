<?php require_login(); require_admin(); ?>

<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <h1>Admin Dashboard</h1>
    <ul>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_categories">Manage Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_ingredients">Manage Ingredients</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_recipes">EDIT RECIPIES</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_approve_recipes">Approve Recipes</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=delete_recipe">Delete Recipe</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_users">Manage Users</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=admin_manage_comments">Manage Comments</a></li>
    </ul>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
