<?php
// activate.php

require_once __DIR__ . '/config/db_config.php';
require_once __DIR__ . '/utils/token.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    global $pdo;
    // Find user by token
    $query = 'SELECT user_id, expires_at FROM user_activation_links WHERE token = :token';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $activation_link = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($activation_link) {
        $user_id = $activation_link['user_id'];
        $expires_at = $activation_link['expires_at'];

        if (new DateTime() < new DateTime($expires_at)) {
            // Activate user account
            $query = 'UPDATE users SET is_active = 1 WHERE id = :user_id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete the activation link
            $query = 'DELETE FROM user_activation_links WHERE token = :token';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            echo 'Your account has been activated!';
        } else {
            echo 'Activation link has expired.';
        }
    } else {
        echo 'Invalid activation link.';
    }
} else {
    echo 'No token provided.';
}

?>
