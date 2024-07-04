<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/ingredient.php';
require_once __DIR__ . '/../../utils/session.php';
require_login(); require_admin();

//session_start();
//if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//    header("Location: login.php");
//    exit();
//}

$ingredients = Ingredient::get_all_ingredients();
?>

<div class="container">
    <h1>Manage Ingredients</h1>
    <form id="ingredient-form">
        <div class="form-group">
            <label for="ingredient-name">Ingredient Name:</label>
            <input type="text" id="ingredient-name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ingredient-unit">Unit:</label>
            <input type="text" id="ingredient-unit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Ingredient</button>
    </form>

    <h2>Existing Ingredients</h2>
    <ul id="ingredient-list">
        <?php foreach ($ingredients as $ingredient): ?>
            <li>
                <?php echo htmlspecialchars($ingredient['name']); ?> (<?php echo htmlspecialchars($ingredient['unit']); ?>)
                <button class="btn btn-danger delete-ingredient-btn" data-ingredient-id="<?php echo $ingredient['id']; ?>">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.getElementById('ingredient-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData();
        formData.append('action', 'create_ingredient');
        formData.append('name', document.getElementById('ingredient-name').value);
        formData.append('unit', document.getElementById('ingredient-unit').value);

        fetch('controllers/ingredient_controller.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Ingredient added successfully!');
                    location.reload();
                } else {
                    alert('Failed to add ingredient. ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });

    document.querySelectorAll('.delete-ingredient-btn').forEach(button => {
        button.addEventListener('click', function() {
            const ingredientId = this.dataset.ingredientId;
            const formData = new FormData();
            formData.append('action', 'delete_ingredient');
            formData.append('id', ingredientId);

            fetch('controllers/ingredient_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Ingredient deleted successfully!');
                        location.reload();
                    } else {
                        alert('Failed to delete ingredient. ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>
