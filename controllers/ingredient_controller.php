<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/Ingredient.php';
require_once __DIR__ . '/../utils/session.php';

//session_start();
$user_id = $_SESSION['user_id'] ?? null;

require_login();
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_ingredient') {
        $name = $_POST['name'] ?? '';
        $unit = $_POST['unit'] ?? '';
        if (empty($name) || empty($unit)) {
            echo json_encode(['success' => false, 'message' => 'Ingredient name and unit are required.']);
            exit();
        }
        $result = Ingredient::add_ingredient($name,$unit);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'update_ingredient') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $unit = $_POST['unit'] ?? '';
        if (empty($id) || empty($name) || empty($unit)) {
            echo json_encode(['success' => false, 'message' => 'Ingredient ID, name, and unit are required.']);
            exit();
        }
        $result = Ingredient::update_ingredient($id, $name, $unit);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'delete_ingredient') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Ingredient ID is required.']);
            exit();
        }
        $result = Ingredient::delete_ingredient($id);
        echo json_encode(['success' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
