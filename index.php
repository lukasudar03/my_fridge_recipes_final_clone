<?php
session_start();
require_once 'config/db_config.php';
require_once 'utils/session.php';
require_once 'controllers/auth_controller.php';
require_once 'controllers/recipe_controller.php';
require_once 'controllers/user_controller.php';
require_once 'controllers/admin_controller.php';

// Routing logika
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
switch ($page) {
    case 'verify':
        include 'templates/pages/verify.php';
        break;
    case 'forgotten_password':
        include 'templates/pages/reset_password.php';
        break;
    case 'recipes':
        include 'templates/pages/recipes.php';
        break;
    case 'recipe_details':
        include 'templates/pages/recipe_details.php';
        break;
    case 'recipes':
        include 'templates/pages/RegRecipes.php';
        break;
    case 'edit_recipe':
        include 'templates/pages/edit_recipe.php';
        break;
    case 'recipe_details':
        include 'templates/pages/RegRecipe_details.php';
        break;
    case 'admin_manage_approve_recipes':
        include 'templates/pages/admin_manage_approve_recipes.php';
        break;
    case 'my_fridge':
        include 'templates/pages/my_fridge.php';
        break;
    case 'profile':
        include 'templates/pages/profile.php';
        break;
    case 'add_recipe':
        include 'templates/pages/add_recipe.php';
        break;
    case 'favorites':
        include 'templates/pages/favorites.php';
        break;
    case 'menu':
        include 'templates/pages/menu.php';
        break;
    case 'delete_recipe':
        include 'templates/pages/delete_recipe.php';
        break;
    case 'favorite_recipes':
        include 'templates/pages/favorite_recipes.php';
        break;
    case 'create_menu':
        include 'templates/pages/create_menu.php';
        break;
    case 'admin_dashboard':
        include 'templates/pages/admin_dashboard.php';
        break;
    case 'admin_manage_categories':
        include 'templates/pages/admin_manage_categories.php';
        break;
    case 'admin_manage_ingredients':
        include 'templates/pages/admin_manage_ingredients.php';
        break;
    case 'admin_manage_recipes':
        include 'templates/pages/admin_manage_recipes.php';
        break;
    case 'admin_manage_users':
        include 'templates/pages/admin_manage_users.php';
        break;
    case 'admin_manage_comments':
        include 'templates/pages/admin_manage_comments.php';
        break;
    case 'login':
        include 'templates/pages/login.php';
        break;
    case 'register':
        include 'templates/pages/register.php';
        break;
    case 'reset_password':
        include 'templates/pages/reset_password.php';
        break;
    default:
        include 'templates/pages/home.php';
        break;
}
?>
