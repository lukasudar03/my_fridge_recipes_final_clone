<?php
require_once __DIR__ . '/../config/db_config.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

if ($query) {
    $sql = "SELECT id, name FROM ingredients WHERE name LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['%' . $query . '%']);
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($ingredients);
} else {
    echo json_encode([]);
}
?>
