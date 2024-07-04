<?php
//require_once __DIR__ . '/../config/db_config.php';
//require_once __DIR__ . '/../models/recipe.php';
//require_once __DIR__ . '/../utils/session.php';
//
//session_start();
//
//
//$user_id = $_SESSION['user_id'] ?? null;
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $action = $_GET['action'] ?? null;
//
//
//    if ($action === 'add_comment') {
//        $user_id = $_SESSION['user_id'];
//        $recipe_id = sanitize_input($_POST['recipe_id']);
//        $content = sanitize_input($_POST['content']);
//        $rating = sanitize_input($_POST['rating']);
//
//        require_once __DIR__ . '/../models/comment.php';
//        Comment::add_comment($user_id, $recipe_id, $content, $rating);
//        header('Location: index.php');
//        exit();
//    }
//    if ($action === 'add_favorite') {
//        $recipe_id = $_GET['id'];
//        if (Recipe::add_to_favorites($user_id, $recipe_id)) {
//            echo json_encode(['success' => true]);
//        } else {
//            echo json_encode(['success' => false]);
//        }
//    }
//
//    if ($action === 'remove_favorite') {
//        $recipe_id = $_GET['id'];
//        if (Recipe::remove_from_favorites($user_id, $recipe_id)) {
//            echo json_encode(['success' => true]);
//        } else {
//            echo json_encode(['success' => false]);
//        }
//    }
//}
//?>
