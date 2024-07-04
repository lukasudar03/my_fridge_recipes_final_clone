<?php
require_once __DIR__ . '/../config/db_config.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

$sql = "SELECT id, name, description FROM recipes WHERE 1=1 AND approved = 1";
$params = [];

if ($query) {
    $sql .= " AND name LIKE ?";
    $params[] = '%' . $query . '%';
}

if ($category_id) {
    $sql .= " AND category_id = ?";
    $params[] = $category_id;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($recipes);
?>
