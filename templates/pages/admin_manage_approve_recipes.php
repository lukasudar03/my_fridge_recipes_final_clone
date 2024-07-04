<?php

include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/recipe.php';
require_once __DIR__ . '/../../utils/session.php';

require_login();
require_admin();

$approved_recipes = Recipe::get_all_approved_recipes();
$unapproved_recipes = Recipe::get_all_unapproved_recipes();

?>

<div class="container">
    <h1>Manage Recipes</h1>
    <h2>Unapproved Recipes</h2>
    <ul id="unapproved-recipes-list">
        <?php foreach ($unapproved_recipes as $recipe): ?>
            <li>
                <?php echo htmlspecialchars($recipe['name']); ?>
                <button class="btn btn-success approve-recipe-btn" data-recipe-id="<?php echo $recipe['id']; ?>">Approve</button>
                <button class="btn btn-danger reject-recipe-btn" data-recipe-id="<?php echo $recipe['id']; ?>">Reject</button>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Approved Recipes</h2>
    <ul id="approved-recipes-list">
        <?php foreach ($approved_recipes as $recipe): ?>
            <li>
                <?php echo htmlspecialchars($recipe['name']); ?>
                <!-- No action buttons for approved recipes, you can add other actions if needed -->
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.approve-recipe-btn').forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.dataset.recipeId;
                const formData = new FormData();
                formData.append('action', 'approve_recipe');
                formData.append('id', recipeId);

                fetch('controllers/recipe_controller.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to approve recipe. ' + (data.message || ''));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });

        document.querySelectorAll('.reject-recipe-btn').forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.dataset.recipeId;
                const reason = prompt('Enter reason for rejection:');
                if (reason) {
                    const formData = new FormData();
                    formData.append('action', 'reject_recipe');
                    formData.append('id', recipeId);
                    formData.append('reason', reason);

                    fetch('controllers/recipe_controller.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Recipe rejected successfully!');
                                location.reload();
                            } else {
                                alert('Failed to reject recipe. ' + (data.message || ''));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Recipe rejected successfully!!');
                        });
                }
            });
        });
    });
</script>
