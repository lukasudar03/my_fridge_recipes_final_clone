<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/comment.php';
session_start();

$response = ['success' => false];

if (isset($_POST['recipe_id'], $_POST['content'], $_POST['rating']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];
    $content = $_POST['content'];
    $rating = $_POST['rating'];

    if (Comment::add_comment($user_id, $recipe_id, $content, $rating)) {
        $response['success'] = true;
    } else {
        $response['message'] = 'User already commented on this recipe.';
    }
} else {
    $response['message'] = 'Invalid input.';
}

echo json_encode($response);
?>
