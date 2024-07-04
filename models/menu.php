<?php
class Menu {
    public static function create_menu($user_id, $name, $day_of_week, $recipes) {
        global $pdo;

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO menus (user_id, name, day_of_week) VALUES (?, ?, ?)');
            $stmt->execute([$user_id, $name, $day_of_week]);
            $menu_id = $pdo->lastInsertId();

            $stmt = $pdo->prepare('INSERT INTO menu_recipes (menu_id, recipe_id) VALUES (?, ?)');
            foreach ($recipes as $recipe_id) {
                $stmt->execute([$menu_id, $recipe_id]);
            }

            $pdo->commit();
            return $menu_id;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    public static function delete_menu($user_id, $menu_id) {
        global $pdo;
        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Delete from menu_recipes table
            $stmt = $pdo->prepare('DELETE FROM menu_recipes WHERE menu_id = ?');
            $stmt->execute([$menu_id]);

            // Delete from menus table
            $stmt = $pdo->prepare('DELETE FROM menus WHERE id = ? AND user_id = ?');
            $stmt->execute([$menu_id, $user_id]);

            // Commit the transaction
            $pdo->commit();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }



    public static function get_menus_by_user($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM menus WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($menus as &$menu) {
            $menu['recipes'] = self::get_recipes_by_menu($menu['id']);
        }

        return $menus;
    }

    public static function get_recipes_by_menu($menu_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT r.* FROM recipes r
            JOIN menu_recipes mr ON r.id = mr.recipe_id
            WHERE mr.menu_id = ?
        ");
        $stmt->execute([$menu_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add_menu($user_id, $name, $day_of_week, $recipes) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO menus (user_id, name, day_of_week) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $name, $day_of_week]);
        $menu_id = $pdo->lastInsertId();

        foreach ($recipes as $recipe_id) {
            $stmt = $pdo->prepare("INSERT INTO menu_recipes (menu_id, recipe_id) VALUES (?, ?)");
            $stmt->execute([$menu_id, $recipe_id]);
        }

        return $menu_id;
    }
}
?>
