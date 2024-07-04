<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <h1>Recipes</h1>
    <div class="form-group">
        <input type="text" id="search-input" class="form-control" placeholder="Search recipes...">
    </div>
    <div class="form-group">
        <label for="category-select">Filter by category:</label>
        <select id="category-select" class="form-control">
            <option value="">All categories</option>
            <?php
            require_once __DIR__ . '/../../models/category.php';
            $categories = Category::get_all_categories();
            foreach ($categories as $category) {
                echo "<option value=\"{$category['id']}\">{$category['name']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="recipe-list" id="recipe-list">
        <!-- Recipes will be displayed here -->
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const recipeList = document.getElementById('recipe-list');

        searchInput.addEventListener('keyup', () => {
            fetchRecipes();
        });

        categorySelect.addEventListener('change', () => {
            fetchRecipes();
        });

        function fetchRecipes() {
            const searchQuery = searchInput.value;
            const categoryId = categorySelect.value;

            fetch(`api/search_recipes2.php?q=${searchQuery}&category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    recipeList.innerHTML = '';
                    if (data.length) {
                        data.forEach(recipe => {
                            const div = document.createElement('div');
                            div.innerHTML = `<h3><a href="index.php?page=recipe_details&id=${recipe.id}">${recipe.name}</a></h3><p>${recipe.description}</p>`;
                            recipeList.appendChild(div);
                        });
                    } else {
                        recipeList.innerHTML = '<p>No recipes found.</p>';
                    }
                });
        }

        fetchRecipes();
    });
</script>
