<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/session.php';

$user_id = $_SESSION['user_id'] ?? null;

require_login();
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'block_user') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'User ID is required.']);
            exit();
        }
        $result = User::block_user($id);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'unblock_user') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'User ID is required.']);
            exit();
        }
        $result = User::unblock_user($id);
        echo json_encode(['success' => $result]);
    }
}

?>