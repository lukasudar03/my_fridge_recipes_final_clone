<?php
//require_once __DIR__ . '/../config/db_config.php';
//require_once __DIR__ . '/../models/user.php';
//require_once __DIR__ . '/../utils/session.php';
//require_once __DIR__ . '/../utils/validation.php';
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    if (isset($_POST['register'])) {
//        $email = sanitize_input($_POST['email']);
//        $password = sanitize_input($_POST['password']);
//        $first_name = sanitize_input($_POST['first_name']);
//        $last_name = sanitize_input($_POST['last_name']);
//        $phone = sanitize_input($_POST['phone']);
//
//        if (validate_email($email) && validate_password($password)) {
//            if (User::register($email, $password, $first_name, $last_name, $phone)) {
//                header('Location: ../index.php?page=login');
//            } else {
//                $error = "Registration failed!";
//            }
//        } else {
//            $error = "Invalid email or password!";
//        }
//    } elseif (isset($_POST['login'])) {
//        $email = sanitize_input($_POST['email']);
//        $password = sanitize_input($_POST['password']);
//
//        if (User::login($email, $password)) {
//            session_start();
//            if ($_SESSION['user_role'] === 'admin') {
//                header('Location: ../index.php?page=admin_dashboard');
//            } else {
//                header('Location: ../index.php');
//            }
//        } else {
//            $error = "Login failed!";
//            header('Location: ../index.php?page=login');
//
//        }
//    } elseif (isset($_POST['reset_password'])) {
//        $email = sanitize_input($_POST['email']);
//        $token = bin2hex(random_bytes(16));
//        if (User::set_reset_token($email, $token)) {
//            $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
//            send_email($email, "Password Reset", "Click here to reset your password: $reset_link");
//            echo "Reset password link has been sent to your email.";
//        } else {
//            echo "Failed to send reset link.";
//        }
//    }
//}
//?>


<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../utils/email.php';
require_once __DIR__ . '/../utils/validation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $email = sanitize_input($_POST['email']);
        $password = sanitize_input($_POST['password']);
        $first_name = sanitize_input($_POST['first_name']);
        $last_name = sanitize_input($_POST['last_name']);
        $phone = sanitize_input($_POST['phone']);

        if (validate_email($email) && validate_password($password)) {
            $token = bin2hex(random_bytes(16));
            if (User::register($email, $password, $first_name, $last_name, $phone, $token)) {
                $reset_link = SITE_URL."index.php?page=verify&token=$token";
                send_email($email, "Verify Account", "Click here to verify your account: $reset_link");
                header('Location: ../index.php?page=login');
            } else {
                $error = "Registration failed!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    } elseif (isset($_POST['login'])) {
        $email = sanitize_input($_POST['email']);
        $password = sanitize_input($_POST['password']);

        // Check if user is active
        $user_status = User::check_user_active_status($email);
        if ($user_status && $user_status['is_active'] == 1) {
            $error = "Your account has been blocked. Please contact support.";
            header('Location: ../index.php?page=login&error=' . urlencode($error));
            exit();
        }

        if (User::login($email, $password)) {
            session_start();
            if ($_SESSION['user_role'] === 'admin') {
                header('Location: ../index.php?page=admin_dashboard');
            } else {
                header('Location: ../index.php');
            }
        } else {
            $error = "Login failed!";
            header('Location: ../index.php?page=login&error=' . urlencode($error));
            exit();
        }
    } elseif (isset($_POST['reset_password'])) {
        if(!isset($_POST['token'])){
            $email = sanitize_input($_POST['email']);
            $token = bin2hex(random_bytes(16));
            if (User::set_reset_token($email, $token)) {
                $reset_link = SITE_URL."index.php?page=forgotten_password&token=$token";
                $error = "We sent you link to reset your password.";
                header("Location: ../index.php?page=login&error=" . urlencode($error));
                send_email($email, "Password Reset", "Click here to reset your password: $reset_link");
                echo "Reset password link has been sent to your email.";
            } else {
                echo "Failed to send reset link.";
            }
        }
        $error = "Password succesfully reset.";
        header("Location: ../index.php?page=login&error=" . urlencode($error));
        User::reset_password($_POST['token'], $_POST['password']);
    }
}
?>
