<?php include __DIR__ . '/../partials/header.php'; ?>
<?php
require_once __DIR__ . '/../../models/recipe.php';
require_once __DIR__ . '/../../models/comment.php';
require_once __DIR__ . '/../../models/favorite.php';

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $recipe = Recipe::get_recipe_by_id($recipe_id);
    $comments = Comment::get_approved_comments2($recipe_id);
} else {
    echo "Recipe not found.";
    exit();
}
?>
<div class="container">
    <h1><?php echo htmlspecialchars($recipe['name']); ?></h1>
    <p><?php echo htmlspecialchars($recipe['description']); ?></p>
    <p>Price: $<?php echo htmlspecialchars($recipe['price']); ?></p>
    <img src="assets/images/<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" style="width: 100%; max-width: 300px;">
    <h2>Ingredients</h2>
    <ul>
        <?php
        require_once __DIR__ . '/../../models/ingredient.php';
        $ingredients = Ingredient::get_ingredients_by_recipe($recipe_id);
        foreach ($ingredients as $ingredient) {
            echo "<li>" . htmlspecialchars($ingredient['name']) . ": " . htmlspecialchars($ingredient['quantity']) . " " . htmlspecialchars($ingredient['unit']) . "</li>";
        }
        ?>
    </ul>
    <?php if (isset($_SESSION['user_id'])): ?>
        <button id="add-favorite" class="btn btn-success">Add to Favorites</button>
    <?php endif; ?>
    <h2>Comments</h2>
    <ul id="comments-list">
        <?php
        foreach ($comments as $comment) {
            echo "<li>" . htmlspecialchars($comment['content']) . " - " . htmlspecialchars($comment['rating']) . " stars - by " . htmlspecialchars($comment['username']) . "</li>";
        }
        ?>
    </ul>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h2>Add a Comment</h2>
        <form id="comment-form">
            <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe['id']); ?>">
            <div class="form-group">
                <label for="content">Comment</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <select id="rating" name="rating" class="form-control" required>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    <?php else: ?>
        <p>You must be logged in to add a comment.</p>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const commentForm = document.getElementById('comment-form');
        const addFavoriteButton = document.getElementById('add-favorite');

        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(commentForm);
            fetch('controllers/add_comment.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to add comment.');
                    }
                });
        });

        if (addFavoriteButton) {
            addFavoriteButton.addEventListener('click', () => {
                const recipeId = "<?php echo htmlspecialchars($recipe['id']); ?>";
                fetch('controllers/add_favorite.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ recipe_id: recipeId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Recipe added to favorites.');
                        } else {
                            alert(data.message || 'Failed to add to favorites.');
                        }
                    });
            });
        }
    });
</script>
