<?php
class Category {
    public static function get_all_categories() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM categories');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create_category($name) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        return $stmt->execute([$name]);
    }

    public static function delete_category($id) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function update_category($id, $name) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }
}
?>
