<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/Recipe.php';
require_once __DIR__ . '/../../utils/session.php';


require_login();
require_admin();
// Fetch approved recipes
$approved_recipes = Recipe::get_all_recipes0();
?>

<div class="container">
    <h1>Manage Approved Recipes</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($approved_recipes as $recipe) : ?>
            <tr>
                <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                <td><?php echo htmlspecialchars($recipe['description']); ?></td>
                <td><?php echo htmlspecialchars($recipe['category_id']); ?></td>
                <td><?php echo htmlspecialchars($recipe['price']); ?></td>
                <td>
                    <a href="index.php?page=edit_recipe&id=<?php echo $recipe['id']; ?>" class="btn btn-primary">Edit</a>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
