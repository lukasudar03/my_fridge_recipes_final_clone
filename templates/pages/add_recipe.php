<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container">
    <h1>Add New Recipe</h1>
    <form id="add-recipe-form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Recipe Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image </label>
            <input type="file" id="image" name="image" class="form-control" required>
        </div>


        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id" class="form-control" required>
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

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>
        <div id="ingredients-list">
            <h3>Ingredients</h3>
        </div>
        <button type="button" id="add-ingredient" class="btn btn-secondary">Add Ingredient</button>
        <button type="submit" class="btn btn-primary">Add Recipe</button>
    </form>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addIngredientBtn = document.getElementById('add-ingredient');
        const ingredientsList = document.getElementById('ingredients-list');

        addIngredientBtn.addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = 'form-group';
            div.innerHTML = `
                <label for="ingredient">Ingredient</label>
                <input type="text" name="ingredients[]" class="form-control" required>
                <label for="quantity">Quantity</label>
                <input type="text" name="quantities[]" class="form-control" required>
                <label for="unit">Unit</label>
                <input type="text" name="units[]" class="form-control" required>
            `;
            ingredientsList.appendChild(div);
        });

        const addRecipeForm = document.getElementById('add-recipe-form');
        addRecipeForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(addRecipeForm);
            formData.append('action', 'add_recipe');

            fetch('controllers/recipe_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Recipe added successfully!');
                        window.location.href = 'index.php?page=recipes';
                    } else {
                        alert('Failed to add recipe. ' + data.message); //ovo se ispise
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
