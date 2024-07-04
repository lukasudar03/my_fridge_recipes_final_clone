<?php
//include __DIR__ . '/../partials/header.php';
//require_once __DIR__ . '/../../models/recipe.php';
//require_once __DIR__ . '/../../utils/session.php';
//
//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php");
//    exit();
//}
//
//$user_id = $_SESSION['user_id'];
//$favorites = Recipe::get_favorite_recipes($user_id);
//?>
<!---->
<!--<div class="container">-->
<!--    <h1>Your Favorite Recipes</h1>-->
<!--    <div class="recipe-list" id="favorite-recipes">-->
<!--        --><?php
//        if (count($favorites) > 0) {
//            foreach ($favorites as $recipe) {
//                echo '<div>';
//                echo '<h3><a href="index.php?page=recipe_details&id=' . $recipe['id'] . '">' . $recipe['name'] . '</a></h3>';
//                echo '<p>' . $recipe['description'] . '</p>';
//                echo '<button class="btn btn-danger" onclick="removeFavorite(' . $recipe['id'] . ')">Remove from Favorites</button>';
//                echo '</div>';
//            }
//        } else {
//            echo '<p>You have no favorite recipes.</p>';
//        }
//        ?>
<!--    </div>-->
<!--</div>-->
<?php //include __DIR__ . '/../partials/footer.php'; ?>
<!---->
<!--<script>-->
<!--    function removeFavorite(recipeId) {-->
<!--        fetch(`controllers/recipe_controller.php?action=remove_favorite&id=${recipeId}`, {-->
<!--            method: 'POST',-->
<!--            headers: {-->
<!--                'Content-Type': 'application/json'-->
<!--            },-->
<!--            body: JSON.stringify({ recipe_id: recipeId })-->
<!--        })-->
<!--            .then(response => response.json())-->
<!--            .then(data => {-->
<!--                if (data.success) {-->
<!--                    location.reload();-->
<!--                } else {-->
<!--                    alert('Failed to remove favorite recipe.');-->
<!--                }-->
<!--            })-->
<!--            .catch(error => console.error('Error:', error));-->
<!--    }-->
<!--</script>-->




<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/recipe.php';
require_once __DIR__ . '/../../utils/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$favorites = Recipe::get_favorite_recipes($user_id);
?>

<div class="container">
    <h1>Your Favorite Recipes</h1>
    <div class="recipe-list" id="favorite-recipes">
        <?php
        if (count($favorites) > 0) {
            foreach ($favorites as $recipe) {
                echo '<div>';
                echo '<h3><a href="index.php?page=recipe_details&id=' . $recipe['id'] . '">' . $recipe['name'] . '</a></h3>';
                echo '<p>' . $recipe['description'] . '</p>';
                echo '<button class="btn btn-danger" onclick="removeFavorite(' . $recipe['id'] . ')">Remove from Favorites</button>';
                echo '</div>';
            }
        } else {
            echo '<p>You have no favorite recipes.</p>';
        }
        ?>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    function removeFavorite(recipeId) {
        fetch(`controllers/recipe_controller.php?action=remove_favorite&id=${recipeId}`, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to remove favorite recipe.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>




