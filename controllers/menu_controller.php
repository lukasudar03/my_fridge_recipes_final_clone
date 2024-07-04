<?php
//require_once __DIR__ . '/../config/db_config.php';
//require_once __DIR__ . '/../models/menu.php';
//require_once __DIR__ . '/../utils/session.php';
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    session_start();
//    $user_id = $_SESSION['user_id'] ?? null;
//    $action = $_POST['action'] ?? '';
//
//    if (!$user_id) {
//        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
//        exit();
//    }
//
//    if ($action === 'create_menu') {
//        $menu_name = $_POST['name'] ?? '';
//        $day_of_week = $_POST['day_of_week'] ?? '';
//        $recipes = json_decode($_POST['recipes'], true) ?? [];
//
//        if (empty($menu_name) || empty($day_of_week) || empty($recipes)) {
//            error_log('Missing fields: ' . json_encode($_POST));
//            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
//            exit();
//        }
//
//        $menu_id = Menu::create_menu($user_id, $menu_name, $day_of_week, $recipes);
//        if ($menu_id) {
//            echo json_encode(['success' => true]);
//        } else {
//            error_log('Failed to create menu: ' . json_encode($_POST));
//            echo json_encode(['success' => false, 'message' => 'Failed to create menu.']);
//        }
//    } elseif ($action === 'delete_menu') {
//        $menu_id = $_POST['id'] ?? '';
//
//        if (empty($menu_id)) {
//            echo json_encode(['success' => false, 'message' => 'Menu ID is required.']);
//            exit();
//        }
//
//        $result = Menu::delete_menu($user_id, $menu_id);
//        if ($result) {
//            echo json_encode(['success' => true]);
//        } else {
//            echo json_encode(['success' => false, 'message' => 'Failed to delete menu.']);
//        }
//    } else {
//        error_log('Invalid action: ' . $action);
//        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
//    }
//} else {
//    error_log('Invalid request method');
//    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
//}


require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/menu.php';
require_once __DIR__ . '/../utils/session.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $action = $_POST['action'] ?? '';

    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit();
    }

    if ($action === 'create_menu') {
        $menu_name = $_POST['name'] ?? '';
        $day_of_week = $_POST['day_of_week'] ?? '';
        $recipes = json_decode($_POST['recipes'], true) ?? [];

        if (empty($menu_name) || empty($day_of_week) || empty($recipes)) {
            error_log('Missing fields: ' . json_encode($_POST));
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        $menu_id = Menu::create_menu($user_id, $menu_name, $day_of_week, $recipes);
        if ($menu_id) {
            echo json_encode(['success' => true]);
        } else {
            error_log('Failed to create menu: ' . json_encode($_POST));
            echo json_encode(['success' => false, 'message' => 'Failed to create menu.']);
        }
    } elseif ($action === 'delete_menu') {
        $menu_id = $_POST['id'] ?? '';

        if (empty($menu_id)) {
            echo json_encode(['success' => false, 'message' => 'Menu ID is required.']);
            exit();
        }

        $result = Menu::delete_menu($user_id, $menu_id);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete menu.']);
        }
    } else {
        error_log('Invalid action: ' . $action);
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
} else {
    error_log('Invalid request method');
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
