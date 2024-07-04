<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_login(); ?>
<div class="container">
    <h1>Create Menu</h1>
    <form action="controllers/menu_controller.php" method="post" class="menu-form">
        <div class="form-group">
            <label for="menu_name">Menu Name</label>
            <input type="text" id="menu_name" name="menu_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="day_of_week">Day of the Week</label>
            <select id="day_of_week" name="day_of_week" class="form-control" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>
        <div class="form-group">
            <label for="recipe_ids">Recipes</label>
            <select multiple id="recipe_ids" name="recipe_ids[]" class="form-control" required>
                <?php
                require_once __DIR__ . '/../../models/recipe.php';
                $recipes = Recipe::get_all_recipes();
                foreach ($recipes as $recipe) {
                    echo "<option value=\"{$recipe['id']}\">{$recipe['name']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="create_menu">Create Menu</button>
    </form>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.menu-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            fetch('controllers/menu_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Menu created successfully.');
                        location.reload();
                    } else {
                        alert('Menu creation failed.');
                    }
                });
        });
    });
</script>
