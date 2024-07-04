<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <h1>My Fridge</h1>
    <div class="form-group">
        <input type="text" id="ingredient-input" class="form-control" placeholder="Enter ingredient...">
        <div id="ingredient-suggestions" class="suggestions"></div>
    </div>
    <button id="refresh-button" class="btn btn-secondary">Refresh</button>
    <div class="drag-drop-area" id="fridge-ingredients">
        <p>Ingredients here.</p>
    </div>
    <div class="recipe-list" id="fridge-recipes">
        <!-- Suggested recipes will be displayed here -->
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ingredientInput = document.getElementById('ingredient-input');
        const ingredientSuggestions = document.getElementById('ingredient-suggestions');
        const fridgeIngredients = document.getElementById('fridge-ingredients');
        const fridgeRecipes = document.getElementById('fridge-recipes');
        const refreshButton = document.getElementById('refresh-button');

        const ingredients = [];

        ingredientInput.addEventListener('input', () => {
            const query = ingredientInput.value.trim();
            if (query) {
                fetch(`api/search_ingredients.php?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        ingredientSuggestions.innerHTML = '';
                        data.forEach(ingredient => {
                            const div = document.createElement('div');
                            div.textContent = ingredient.name;
                            div.classList.add('suggestion');
                            div.addEventListener('click', () => {
                                if (!ingredients.includes(ingredient.name)) {
                                    ingredients.push(ingredient.name);
                                    updateFridgeIngredients();
                                }
                                ingredientInput.value = '';
                                ingredientSuggestions.innerHTML = '';
                            });
                            ingredientSuggestions.appendChild(div);
                        });
                    });
            } else {
                ingredientSuggestions.innerHTML = '';
            }
        });

        fridgeIngredients.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        fridgeIngredients.addEventListener('drop', (e) => {
            e.preventDefault();
            const data = e.dataTransfer.getData('text');
            if (data && !ingredients.includes(data)) {
                ingredients.push(data);
                updateFridgeIngredients();
            }
        });

        refreshButton.addEventListener('click', () => {
            ingredients.length = 0;
            updateFridgeIngredients();
            fridgeRecipes.innerHTML = '';
            searchRecipes(); // Refresh to show all recipes again
        });

        function updateFridgeIngredients() {
            fridgeIngredients.innerHTML = '';
            ingredients.forEach(ingredient => {
                const div = document.createElement('div');
                div.textContent = ingredient;
                div.draggable = true;
                div.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text', ingredient);
                });
                fridgeIngredients.appendChild(div);
            });
            searchRecipes();
        }

        function searchRecipes() {
            const query = ingredients.join(',');
            fetch(`api/search_recipes.php?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    fridgeRecipes.innerHTML = '';
                    if (data.length) {
                        data.forEach(recipe => {
                            const div = document.createElement('div');
                            div.innerHTML = `<h3><a href="index.php?page=recipe_details&id=${recipe.id}">${recipe.name}</a></h3><p>${recipe.description}</p>`;
                            fridgeRecipes.appendChild(div);
                        });
                    } else {
                        fridgeRecipes.innerHTML = '<p>No recipes found.</p>';
                    }
                });
        }

        // Fetch all recipes on initial load
        searchRecipes();
    });
</script>
