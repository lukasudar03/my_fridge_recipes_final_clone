<?php
class Ingredient {
    public static function get_ingredients_by_recipe($recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT i.name, ri.quantity, i.unit FROM recipe_ingredients ri JOIN ingredients i ON ri.ingredient_id = i.id WHERE ri.recipe_id = ?");
        $stmt->execute([$recipe_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function get_all_ingredients() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM ingredients');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function add_ingredient($name, $unit) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO ingredients (name, unit) VALUES (?, ?)');
        $stmt->execute([$name, $unit]);
        return $pdo->lastInsertId();
    }

    public static function update_ingredient($id, $name, $unit) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE ingredients SET name = ?, unit = ? WHERE id = ?');
        return $stmt->execute([$name, $unit, $id]);
    }

    public static function delete_ingredient($id) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM ingredients WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>
