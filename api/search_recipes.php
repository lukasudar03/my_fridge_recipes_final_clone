<?php
//require_once __DIR__ . '/../config/db_config.php';
//
//$query = isset($_GET['q']) ? $_GET['q'] : '';
//
//if ($query) {
//    $ingredients = explode(',', $query);
//    $placeholders = implode(',', array_fill(0, count($ingredients), '?'));
//
//    $sql = "
//        SELECT r.id, r.name, r.description
//        FROM recipes r
//        JOIN recipe_ingredients ri ON r.id = ri.recipe_id
//        JOIN ingredients i ON ri.ingredient_id = i.id
//        WHERE i.name IN ($placeholders)
//        GROUP BY r.id, r.name, r.description
//        HAVING COUNT(DISTINCT i.name) >= ?
//    ";
//
//    $stmt = $pdo->prepare($sql);
//    $params = array_merge($ingredients, [count($ingredients)]);
//    $stmt->execute($params);
//    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    echo json_encode($recipes);
//} else {
//    $sql = "SELECT id, name, description FROM recipes WHERE 1=1 AND approved = 1";
//    $stmt = $pdo->query($sql);
//    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    echo json_encode($recipes);
//}
//?>

<?php
require_once __DIR__ . '/../config/db_config.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

if ($query) {
    $ingredients = explode(',', $query);
    $placeholders = implode(',', array_fill(0, count($ingredients), '?'));

    $sql = "
        SELECT r.id, r.name, r.description
        FROM recipes r 
        JOIN recipe_ingredients ri ON r.id = ri.recipe_id
        JOIN ingredients i ON ri.ingredient_id = i.id 
        WHERE i.name IN ($placeholders) 
        AND r.approved = 1
        GROUP BY r.id, r.name, r.description
        HAVING COUNT(DISTINCT i.name) >= ?
    ";

    $stmt = $pdo->prepare($sql);
    $params = array_merge($ingredients, [count($ingredients)]);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($recipes);
} else {
    $sql = "SELECT id, name, description FROM recipes WHERE approved = 1";
    $stmt = $pdo->query($sql);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($recipes);
}
?>
