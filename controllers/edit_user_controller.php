<?php
session_start();
require_once __DIR__ . '/../config/db_config.php';

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $user_id = $_SESSION['user_id'];
    $fields_to_update = [];
    $params = [];

    if (!empty($_POST['first_name'])) {
        $fields_to_update[] = 'first_name = ?';
        $params[] = $_POST['first_name'];
        $_SESSION['first_name'] = $_POST['first_name'];
    }

    if (!empty($_POST['last_name'])) {
        $fields_to_update[] = 'last_name = ?';
        $params[] = $_POST['last_name'];
        $_SESSION['last_name'] = $_POST['last_name'];
    }

    if (!empty($_POST['phone'])) {
        $fields_to_update[] = 'phone = ?';
        $params[] = $_POST['phone'];
        $_SESSION['phone'] = $_POST['phone'];
    }

    if (!empty($_POST['password'])) {
        $encpass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $fields_to_update[] = 'password = ?';
        $params[] = $encpass;
    }

    if (!empty($fields_to_update)) {
        $params[] = $user_id;
        $sql = "UPDATE users SET " . implode(", ", $fields_to_update) . " WHERE id = ?";
        $update_query = $pdo->prepare($sql);
        try {
            $update_query->execute($params);
            $response['success'] = true;
        } catch (Exception $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'No fields to update.';
    }
}

echo json_encode($response);
