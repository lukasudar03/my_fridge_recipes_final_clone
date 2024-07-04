
<?php
require_once __DIR__ . '/../config/db_config.php';

class Comment {
    public static function has_commented($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM comments WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$user_id, $recipe_id]);
        return $stmt->fetchColumn() > 0;
    }
//    public static function add_comment($user_id, $recipe_id, $content, $rating) {
//        global $pdo;
//        $stmt = $pdo->prepare("INSERT INTO comments (user_id, recipe_id, content, rating) VALUES (?, ?, ?, ?)");
//        return $stmt->execute([$user_id, $recipe_id, $content, $rating]);
//    }

    public static function add_comment($user_id, $recipe_id, $content, $rating) {
        if (!self::has_commented($user_id, $recipe_id)) {
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO comments (user_id, recipe_id, content, rating) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$user_id, $recipe_id, $content, $rating]);
        } else {
            return false; // Korisnik je već komentarisao ovaj recept
        }
    }

    public static function get_comments_by_recipe($recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT c.content, c.rating, u.first_name as username
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.recipe_id = ?
        ");
        $stmt->execute([$recipe_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_all_comments() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE approved = 1 '); // AND recipe_id = :recipe_id
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    public static function approve_comment($id) {
//        global $pdo;
//        $stmt = $pdo->prepare('UPDATE comments SET status = ? WHERE id = ?');
//        return $stmt->execute(['approved', $id]);
//    }

    public static function get_approved_comments() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM comments WHERE approved = 1');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_approved_comments2($recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT c.content, c.rating, u.first_name as username
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.recipe_id = ? AND approved = 1
        ");
        $stmt->execute([$recipe_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function get_unapproved_comments() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM comments WHERE approved = 0');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function approve_comment($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE comments SET approved = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function reject_comment($id, $reason) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE comments SET approved = 3, rejection_reason = ? WHERE id = ?');
        return $stmt->execute([$reason, $id]);
    }
}
?>