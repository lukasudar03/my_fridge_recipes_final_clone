<?php
require_once __DIR__ . '/../config/db_config.php';

class Favorite {
//    public static function add_favorite($user_id, $recipe_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
//        return $stmt->execute([$user_id, $recipe_id]);
//    }
    public static function add_favorite($user_id, $recipe_id) {
        if (!self::is_favorite($user_id, $recipe_id)) {
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
            return $stmt->execute([$user_id, $recipe_id]);
        } else {
            return false; // Recept je već u favoritima
        }
    }
    public static function is_favorite($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$user_id, $recipe_id]);
        return $stmt->fetchColumn() > 0;
    }

    public static function get_favorites_by_user($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT r.*
            FROM favorites f
            JOIN recipes r ON f.recipe_id = r.id
            WHERE f.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function remove_favorite($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?');
        return $stmt->execute([$user_id, $recipe_id]);
    }

}
?>


