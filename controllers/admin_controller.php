<?php
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ . '/../models/ingredient.php';
require_once __DIR__ . '/../models/recipe.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $name = sanitize_input($_POST['category_name']);
        if (Category::create_category($name)) {
            header('Location: ../index.php?page=admin_manage_categories');
        } else {
            $error = "Failed to add category!";
        }
    } elseif (isset($_POST['add_ingredient'])) {
        $name = sanitize_input($_POST['ingredient_name']);
        $unit = sanitize_input($_POST['ingredient_unit']);
        if (Ingredient::add_ingredient($name)) {
            header('Location: ../index.php?page=admin_manage_ingredients');
        } else {
            $error = "Failed to add ingredient!";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        $id = sanitize_input($_GET['id']);
        if ($_GET['action'] === 'delete_category') {
            if (Category::delete_category($id)) {
                header('Location: ../index.php?page=admin_manage_categories');
            } else {
                $error = "Failed to delete category!";
            }
        } elseif ($_GET['action'] === 'delete_ingredient') {
            if (Ingredient::delete_ingredient($id)) {
                header('Location: ../index.php?page=admin_manage_ingredients');
            } else {
                $error = "Failed to delete ingredient!";
            }
        } elseif ($_GET['action'] === 'delete_recipe') {
            if (Recipe::delete_recipe($id)) {
                header('Location: ../index.php?page=admin_manage_recipes');
            } else {
                $error = "Failed to delete recipe!";
            }
        } elseif ($_GET['action'] === 'delete_user') {
            if (User::delete_user($id)) {
                header('Location: ../index.php?page=admin_manage_users');
            } else {
                $error = "Failed to delete user!";
            }
        } elseif ($_GET['action'] === 'approve_comment') {
            if (Comment::approve_comment($id)) {
                header('Location: ../index.php?page=admin_manage_comments');
            } else {
                $error = "Failed to approve comment!";
            }
        } elseif ($_GET['action'] === 'delete_comment') {
            if (Comment::delete_comment($id)) {
                header('Location: ../index.php?page=admin_manage_comments');
            } else {
                $error = "Failed to delete comment!";
            }
        }
    }
}
?>
