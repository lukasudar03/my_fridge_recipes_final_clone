<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/recipe.php';
require_once __DIR__ . '/../../models/menu.php';
require_once __DIR__ . '/../../utils/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$recipes = Recipe::get_favorite_recipes($user_id); // Using favorite recipes
$menus = Menu::get_menus_by_user($user_id);
?>

<div class="container">
    <h1>Create Your Weekly Menu</h1>
    <form id="menu-form">
        <div class="form-group">
            <label for="menu-name">Menu Name:</label>
            <input type="text" id="menu-name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="day-of-week">Day of the Week:</label>
            <select id="day-of-week" class="form-control" required>
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
            <label for="recipes">Select Recipes:</label>
            <select id="recipes" class="form-control" multiple required>
                <?php
                foreach ($recipes as $recipe) {
                    echo '<option value="' . $recipe['id'] . '">' . $recipe['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Menu</button>
    </form>

    <h2>Your Menus</h2>
    <div class="menu-list">
        <?php
        foreach ($menus as $menu) {
            echo '<div>';
            echo '<h3>' . $menu['name'] . ' (' . $menu['day_of_week'] . ')</h3>';
            echo '<ul>';
            foreach ($menu['recipes'] as $recipe) {
                echo '<li>' . $recipe['name'] . '</li>';
            }
            echo '</ul>';
            echo '<button class="btn btn-danger delete-menu-btn" data-menu-id="' . $menu['id'] . '">Delete</button>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<!--<script>-->
<!--    document.getElementById('menu-form').addEventListener('submit', function(event) {-->
<!--        event.preventDefault();-->
<!---->
<!--        const formData = new FormData(this);-->
<!--        const menuName = document.getElementById('menu-name').value;-->
<!--        const dayOfWeek = document.getElementById('day-of-week').value;-->
<!--        const selectedRecipes = Array.from(document.getElementById('recipes').selectedOptions).map(option => option.value);-->
<!--        formData.append('name', menuName);-->
<!--        formData.append('day_of_week', dayOfWeek);-->
<!--        formData.append('recipes', JSON.stringify(selectedRecipes));-->
<!--        formData.append('action', 'create_menu');-->
<!---->
<!--        fetch('controllers/menu_controller.php', {-->
<!--            method: 'POST',-->
<!--            body: formData-->
<!--        })-->
<!--            .then(response => response.json())-->
<!--            .then(data => {-->
<!--                if (data.success) {-->
<!--                    alert('Menu created successfully!');-->
<!--                    location.reload();-->
<!--                } else {-->
<!--                    alert('Failed to create menu. ' + (data.message || ''));-->
<!--                }-->
<!--            })-->
<!--            .catch(error => {-->
<!--                console.error('Error:', error);-->
<!--                alert('An error occurred. Please try again.');-->
<!--            });-->
<!--    });-->
<!---->
<!--    document.querySelectorAll('.delete-menu-btn').forEach(button => {-->
<!--        button.addEventListener('click', function() {-->
<!--            if (confirm('Are you sure you want to delete this menu?')) {-->
<!--                const menuId = this.dataset.menuId;-->
<!--                const formData = new FormData();-->
<!--                formData.append('action', 'delete_menu');-->
<!--                formData.append('id', menuId);-->
<!---->
<!--                fetch('controllers/menu_controller.php', {-->
<!--                    method: 'POST',-->
<!--                    body: formData-->
<!--                })-->
<!--                    .then(response => response.json())-->
<!--                    .then(data => {-->
<!--                        if (data.success) {-->
<!--                            alert('Menu deleted successfully!');-->
<!--                            location.reload();-->
<!--                        } else {-->
<!--                            alert('Failed to delete menu. ' + (data.message || ''));-->
<!--                        }-->
<!--                    })-->
<!--                    .catch(error => {-->
<!--                        console.error('Error:', error);-->
<!--                        alert('An error occurred. Please try again.');-->
<!--                    });-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->


<script>
    document.getElementById('menu-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const menuName = document.getElementById('menu-name').value;
        const dayOfWeek = document.getElementById('day-of-week').value;
        const selectedRecipes = Array.from(document.getElementById('recipes').selectedOptions).map(option => option.value);
        formData.append('name', menuName);
        formData.append('day_of_week', dayOfWeek);
        formData.append('recipes', JSON.stringify(selectedRecipes));
        formData.append('action', 'create_menu');

        fetch('controllers/menu_controller.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text()) // Promenimo u .text() da bismo mogli da logujemo sirovi odgovor
            .then(text => {
                console.log('Server response:', text); // Logujemo sirovi odgovor
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert('Menu created successfully!');
                        location.reload();
                    } else {
                        console.error('Failed to create menu:', data.message);
                        alert('Failed to create menu. ' + (data.message || ''));
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error, text);
                    alert('An error occurred while processing the response. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });

    document.querySelectorAll('.delete-menu-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this menu?')) {
                const menuId = this.dataset.menuId;
                const formData = new FormData();
                formData.append('action', 'delete_menu');
                formData.append('id', menuId);

                fetch('controllers/menu_controller.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text()) // Promenimo u .text() da bismo mogli da logujemo sirovi odgovor
                    .then(text => {
                        console.log('Server response:', text); // Logujemo sirovi odgovor
                        try {
                            const data = JSON.parse(text);
                            if (data.success) {
                                alert('Menu deleted successfully!');
                                location.reload();
                            } else {
                                console.error('Failed to delete menu:', data.message);
                                alert('Failed to delete menu. ' + (data.message || ''));
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error, text);
                            alert('An error occurred while processing the response. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });
    });
</script>

