<?php
require_once __DIR__ . '/../config/db_config.php';

$sql = "SELECT id, name, description, price, image FROM recipes WHERE approved = 1";
$stmt = $pdo->query($sql);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($recipes);
?>
