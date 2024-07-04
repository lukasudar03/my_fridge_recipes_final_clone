<?php
//require_once __DIR__ . '/../config/db_config.php';
//require_once __DIR__ . '/../models/user.php';
//require_once __DIR__ . '/../utils/session.php';
//require_once __DIR__ . '/../utils/validation.php';
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    session_start();
//    $user_id = $_SESSION['user_id'];
//    $first_name = sanitize_input($_POST['first_name']);
//    $last_name = sanitize_input($_POST['last_name']);
//    $phone = sanitize_input($_POST['phone']);
//    $password = isset($_POST['password']) && $_POST['password'] ? sanitize_input($_POST['password']) : null;
//
//    if (User::update_profile($user_id, $first_name, $last_name, $phone, $password)) {
//        $_SESSION['first_name'] = $first_name;
//        $_SESSION['last_name'] = $last_name;
//        $_SESSION['phone'] = $phone;
//        echo json_encode(['success' => true]);
//    } else {
//        echo json_encode(['success' => false]);
//    }
//}
//
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//require_once __DIR__ . '/../models/User.php';
//require_once __DIR__ . '/../utils/email.php';
//require_once __DIR__ . '/../utils/token.php'; // Pretpostavljamo da već postoji funkcija za generisanje tokena
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $action = $_POST['action'] ?? '';
//
//    if ($action === 'register') {
//        $email = $_POST['email'] ?? '';
//        $password = $_POST['password'] ?? '';
//        $confirm_password = $_POST['confirm_password'] ?? '';
//
//        if (empty($email) || empty($password) || empty($confirm_password)) {
//            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
//            exit();
//        }
//
//        if ($password !== $confirm_password) {
//            echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
//            exit();
//        }
//
//        $existing_user = User::get_user_by_email($email);
//        if ($existing_user) {
//            echo json_encode(['success' => false, 'message' => 'Email already in use.']);
//            exit();
//        }
//
//        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
//        $activation_token = generate_token();
//
//        $user_id = User::create_user($email, $hashed_password, $activation_token);
//        if ($user_id) {
//            $activation_link = "http://yourwebsite.com/activate.php?token=$activation_token";
//            send_email($email, "Activate your account", "Click the following link to activate your account: $activation_link");
//            echo json_encode(['success' => true]);
//        } else {
//            echo json_encode(['success' => false, 'message' => 'Failed to register user.']);
//        }
//    }
//}

?>


<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../utils/email.php';
require_once __DIR__ . '/../utils/token.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($email) || empty($password) || empty($confirm_password)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        if ($password !== $confirm_password) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
            exit();
        }

        $existing_user = User::get_user_by_email($email);
        if ($existing_user) {
            echo json_encode(['success' => false, 'message' => 'Email already in use.']);
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $activation_token = generate_token();

        $user_id = User::create_user($email, $hashed_password, $activation_token);
        if ($user_id) {
            $activation_link = "http://yourwebsite.com/activate.php?token=$activation_token";
            send_email($email, "Activate your account", "Click the following link to activate your account: $activation_link");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to register user.']);
        }
    } elseif ($action === 'update_profile') {
        session_start();
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit();
        }

        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($first_name) || empty($last_name) || empty($phone)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        $hashed_password = null;
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        }

        $result = User::update_user($user_id, $first_name, $last_name, $phone, $hashed_password);
        if ($result) {
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['phone'] = $phone;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
        }
    }
}
?>

