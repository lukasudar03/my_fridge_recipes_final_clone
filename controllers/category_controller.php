<?php

require_once __DIR__ . '/../config/db_config.php';
require  '../models/category.php';
require  '../utils/session.php';

require_login();
require_admin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_category') {
        $name = $_POST['name'] ?? '';
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Category name is required.']);
            exit();
        }
        $result = Category::create_category($name);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'delete_category') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Category ID is required.']);
            exit();
        }
        $result = Category::delete_category($id);
        echo json_encode(['success' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
