<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ../index.php?page=login');
        exit();
    }
}
function ensure_logged_in() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

function require_admin() {
    if (!is_admin()) {
        header('Location: ../index.php');
        exit();
    }
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>