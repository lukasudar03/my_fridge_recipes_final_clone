<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <h1>Home</h1>
    <div class="recipe-list" id="home-recipes">
        <!-- Recipes will be displayed here -->
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const homeRecipes = document.getElementById('home-recipes');

        fetch('api/get_recipes.php')
            .then(response => response.json())
            .then(data => {
                homeRecipes.innerHTML = '';
                if (data.length) {
                    data.forEach(recipe => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                        <h3><a href="index.php?page=recipe_details&id=${recipe.id}">${recipe.name}</a></h3>
                        <p>${recipe.description}</p>
                        <p>Price: $${recipe.price}</p>
                        <img src="assets/images/${recipe.image}" alt="${recipe.name}" style="width: 100%; max-width: 300px;">
                    `;
                        homeRecipes.appendChild(div);
                    });
                } else {
                    homeRecipes.innerHTML = '<p>No recipes found.</p>';
                }
            });
    });
</script>
