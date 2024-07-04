<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_login(); ?>
<div class="container">
    <h1>Favorite Recipes</h1>
    <div id="favorite-recipes-list">
        <!-- Favorite recipes will be displayed here -->
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const favoriteRecipesList = document.getElementById('favorite-recipes-list');

        fetch('controllers/recipe_controller.php?action=get_favorites')
            .then(response => response.json())
            .then(data => {
                favoriteRecipesList.innerHTML = '';
                if (data.length) {
                    data.forEach(recipe => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                        <h3><a href="index.php?page=recipe_details&id=${recipe.id}">${recipe.name}</a></h3>
                        <p>${recipe.description}</p>
                        <button class="btn btn-danger" onclick="removeFromFavorites(${recipe.id})">Remove</button>
                    `;
                        favoriteRecipesList.appendChild(div);
                    });
                } else {
                    favoriteRecipesList.innerHTML = '<p>No favorite recipes found.</p>';
                }
            });
    });

    function removeFromFavorites(recipeId) {
        fetch(`controllers/recipe_controller.php?action=remove_favorite&id=${recipeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to remove favorite recipe.');
                }
            });
    }

</script>
