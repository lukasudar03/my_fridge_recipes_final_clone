<?php
//require_once __DIR__ . '/../config/db_config.php';
//require_once __DIR__ . '/../models/favorite.php';
//session_start();
//
//$response = ['success' => false];
//
//if (isset($_SESSION['user_id'])) {
//    $user_id = $_SESSION['user_id'];
//    $data = json_decode(file_get_contents('php://input'), true);
//
//    if (isset($data['recipe_id'])) {
//        $recipe_id = $data['recipe_id'];
//
//        if (Favorite::remove_favorite($user_id, $recipe_id)) {
//            $response['success'] = true;
//
//        } else {
//            $response['message'] = 'Failed to remove from favorites.';
//        }
//    } else {
//        $response['message'] = 'Recipe ID not provided.';
//    }
//} else {
//    $response['message'] = 'User not authenticated.';
//}
//
//echo json_encode($response);
//?>
