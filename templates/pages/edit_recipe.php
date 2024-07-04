<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/Recipe.php';
require_once __DIR__ . '/../../models/category.php';
require_once __DIR__ . '/../../utils/session.php';

require_login();
require_admin();

$recipe_id = $_GET['id'] ?? null;
if (!$recipe_id) {
    header("Location: admin_manage_recipes.php");
    exit();
}

$recipe = Recipe::Editget_recipe_by_id($recipe_id);
$categories = Category::get_all_categories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';

    if (Recipe::Editupdate_recipe($recipe_id, $name, $description, $category_id, $price)) {
        header("Location: index.php?page=admin_manage_recipes");
        exit();
    } else {
        $error = "Failed to update recipe.";
    }
}
?>

<div class="container">
    <h1>Edit Recipe</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($recipe['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $recipe['category_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($recipe['price']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Recipe</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
