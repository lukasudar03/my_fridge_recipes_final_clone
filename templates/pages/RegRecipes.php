<?php //include __DIR__ . '/../partials/header.php'; ?>
<!--<div class="container">-->
<!--    <h1>All Recipes</h1>-->
<!--    <div class="form-group">-->
<!--        <input type="text" id="recipe-input" class="form-control" placeholder="Search for recipes...">-->
<!--        <div id="recipe-suggestions" class="suggestions"></div>-->
<!--    </div>-->
<!--    <div class="recipe-list" id="all-recipes">-->
<!--        --><?php
//        require_once __DIR__ . '/../../models/recipe.php';
//        $recipes = Recipe::get_all_recipes();
//
//        foreach ($recipes as $recipe) {
//            echo '<div>';
//            echo '<h3><a href="index.php?page=recipe_details&id=' . $recipe['id'] . '">' . $recipe['name'] . '</a></h3>';
//            echo '<p>' . $recipe['description'] . '</p>';
//            echo '</div>';
//        }
//        ?>
<!--    </div>-->
<!--</div>-->
<?php //include __DIR__ . '/../partials/footer.php'; ?>
<!---->
<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', () => {-->
<!--        const recipeInput = document.getElementById('recipe-input');-->
<!--        const allRecipes = document.getElementById('all-recipes');-->
<!---->
<!--        recipeInput.addEventListener('input', () => {-->
<!--            const query = recipeInput.value.trim();-->
<!--            searchRecipes(query);-->
<!--        });-->
<!---->
<!--        function searchRecipes(query) {-->
<!--            fetch(`api/search_recipes2.php?q=${query}`)-->
<!--                .then(response => response.json())-->
<!--                .then(data => {-->
<!--                    allRecipes.innerHTML = '';-->
<!--                    if (data.length) {-->
<!--                        data.forEach(recipe => {-->
<!--                            const div = document.createElement('div');-->
<!--                            div.innerHTML = `<h3><a href="index.php?page=recipe_details&id=${recipe.id}">${recipe.name}</a></h3><p>${recipe.description}</p>`;-->
<!--                            allRecipes.appendChild(div);-->
<!--                        });-->
<!--                    } else {-->
<!--                        allRecipes.innerHTML = '<p>No recipes found.</p>';-->
<!--                    }-->
<!--                });-->
<!--        }-->
<!---->
<!--        // Fetch all recipes on initial load-->
<!--        searchRecipes('');-->
<!--    });-->
<!--</script>-->
