<?php //include __DIR__ . '/../partials/header.php'; ?>
<!---->
<!--<div class="container">-->
<!--    <h1>Delete Recipe</h1>-->
<!--    <div id="recipe-list">-->
<!--        --><?php
//        require_once __DIR__ . '/../../models/recipe.php';  // Proveri ovu putanju
//        $recipes = Recipe::get_all_recipes();
//        if (count($recipes) > 0) {
//            echo '<div class="list-group">';
//            foreach ($recipes as $recipe) {
//                echo '<div class="list-group-item d-flex justify-content-between align-items-center">' .
//                    '<div>' .
//                    '<h5>' . htmlspecialchars($recipe['name']) . '</h5>' .
//                    '<p>' . htmlspecialchars($recipe['description']) . '</p>' .
//                    '</div>' .
//                    '<button class="btn btn-danger delete-recipe-btn" data-id="' . $recipe['id'] . '">Delete</button>' .
//                    '</div>';
//            }
//            echo '</div>';
//        } else {
//            echo '<p>No recipes found.</p>';
//        }
//        ?>
<!--    </div>-->
<!--</div>-->
<!---->
<?php //include __DIR__ . '/../partials/footer.php'; ?>
<!---->
<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', () => {-->
<!--        const deleteRecipeButtons = document.querySelectorAll('.delete-recipe-btn');-->
<!---->
<!--        deleteRecipeButtons.forEach(button => {-->
<!--            button.addEventListener('click', (e) => {-->
<!--                const recipeId = e.target.getAttribute('data-id');-->
<!---->
<!--                if (confirm('Are you sure you want to delete this recipe?')) {-->
<!--                    fetch('controllers/recipe_controller.php', {-->
<!--                        method: 'POST',-->
<!--                        body: JSON.stringify({ action: 'delete_recipe', id: recipeId }),-->
<!--                        headers: {-->
<!--                            'Content-Type': 'application/json'-->
<!--                        }-->
<!--                    })-->
<!--                        .then(response => response.json())-->
<!--                        .then(data => {-->
<!--                            if (data.success) {-->
<!--                                alert('Recipe deleted successfully!');-->
<!--                                location.reload();-->
<!--                            } else {-->
<!--                                alert('Failed to delete recipe. ' + data.message);-->
<!--                            }-->
<!--                        })-->
<!--                        .catch(error => {-->
<!--                            console.error('Error:', error);-->
<!--                        });-->
<!--                }-->
<!--            });-->
<!--        });-->
<!--    });-->
<!---->
<!--</script>-->

<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h1>Delete Recipe</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require_once __DIR__ . '/../../models/recipe.php';
        $recipes = Recipe::get_all_recipes2();
        foreach ($recipes as $recipe) {
            echo "<tr>";
            echo "<td>{$recipe['name']}</td>";
            echo "<td>{$recipe['category_name']}</td>";
            echo "<td><button class='btn btn-danger delete-recipe-btn' data-recipe-id='{$recipe['id']}'>Delete</button></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-recipe-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const recipeId = e.target.dataset.recipeId;

                if (confirm('Are you sure you want to delete this recipe?')) {
                    fetch('controllers/recipe_controller.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'delete_recipe',
                            id: recipeId
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Failed to delete recipe. ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    });


</script>