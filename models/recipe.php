<?php

class Recipe {
//    public static function add_recipe($user_id, $name, $description, $image, $price, $category_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("INSERT INTO recipes (user_id, name, description, image, price, category_id) VALUES (?, ?, ?, ?, ?, ?)");
//        return $stmt->execute([$user_id, $name, $description, $image, $price, $category_id]);
//    }

//    public static function get_favorite_recipes($user_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("SELECT * FROM recipes r INNER JOIN favorite_recipes f ON r.id = f.recipe_id WHERE f.user_id = ?");
//        $stmt->execute([$user_id]);
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }
//
//    public static function remove_favorite_recipe($user_id, $recipe_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("DELETE FROM favorite_recipes WHERE user_id = ? AND recipe_id = ?");
//        return $stmt->execute([$user_id, $recipe_id]);
//    }
//
//    public static function add_recipe($user_id, $name, $description, $image, $price, $ingredients) {
//        global $pdo;
//
//        try {
//            $pdo->beginTransaction();
//
//            $stmt = $pdo->prepare('INSERT INTO recipes (user_id, name, description, image, price) VALUES (?, ?, ?, ?, ?)');
//            $stmt->execute([$user_id, $name, $description, $image, $price]);
//
//            $recipe_id = $pdo->lastInsertId();
//
//            foreach ($ingredients as $ingredient) {
//                $stmt = $pdo->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity, unit) VALUES (?, ?, ?, ?)');
//                $stmt->execute([$recipe_id, $ingredient['id'], $ingredient['quantity'], $ingredient['unit']]);
//            }
//
//            $pdo->commit();
//            return true;
//        } catch (Exception $e) {
//            $pdo->rollBack();
//            return false;
//        }
//    }

    public static function get_favorite_recipes($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.* FROM recipes r INNER JOIN favorites fr ON r.id = fr.recipe_id WHERE fr.user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public static function get_favorite_recipes2($user_id) {
        global $pdo;
        $stmt = $pdo->prepare('
        SELECT r.id AS recipe_id, r.name AS recipe_name
        FROM favorites fr
        JOIN recipes r ON fr.recipe_id = r.id
        WHERE fr.user_id = ?
    ');
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    public static function get_favorite_recipes($user_id) {
//        $db = getDB();
//        $stmt = $db->prepare('
//            SELECT r.*
//            FROM recipes r
//            JOIN favorite_recipes f ON r.id = f.recipe_id
//            WHERE f.user_id = ?
//        ');
//        $stmt->execute([$user_id]);
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }
//
//    public static function remove_favorite_recipe($user_id, $recipe_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("DELETE FROM favorite_recipes WHERE user_id = ? AND recipe_id = ?");
//        return $stmt->execute([$user_id, $recipe_id]);
//    }
    public static function get_all_recipes() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM recipes WHERE approved = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function get_all_recipes0() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM recipes ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function Editupdate_recipe($id, $name, $description, $category_id, $price) {
        global $pdo;
        $query = 'UPDATE recipes SET name = :name, description = :description, category_id = :category_id, price = :price WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function get_all_recipes2() {
        global $pdo;

        $stmt = $pdo->query('
        SELECT recipes.*, categories.name as category_name 
        FROM recipes 
        JOIN categories ON recipes.category_id = categories.id
    ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function get_user_email_by_recipe_id($recipe_id) {
        global $db;

        $query = 'SELECT u.email FROM recipes r
                  JOIN users u ON r.user_id = u.id
                  WHERE r.id = :recipe_id';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

//    public static function approve_recipe($id) {
//        global $pdo;
//        $stmt = $pdo->prepare('UPDATE recipes SET status = ? WHERE id = ?');
//        return $stmt->execute(['approved', $id]);
//    }

    public static function get_all_approved_recipes() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM recipes WHERE approved = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_all_unapproved_recipes() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM recipes WHERE approved = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function approve_recipe($id) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE recipes SET approved = 1 WHERE id = ?");
         return $stmt->execute([$id]);
    }

    public static function reject_recipe($id, $reason) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE recipes SET approved = -1, rejection_reason = ? WHERE id = ?");
        return $stmt->execute([$reason, $id]);
    }

    public static function create_recipe($name, $ingredients, $image, $description, $estimated_cost) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO recipes (name, image, description, estimated_cost) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $image, $description, $estimated_cost]);
        $recipe_id = $pdo->lastInsertId();

        foreach ($ingredients as $ingredient) {
            $stmt = $pdo->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)');
            $stmt->execute([$recipe_id, $ingredient['id'], $ingredient['quantity']]);
        }

        return $recipe_id;
    }

    public static function update_recipe($id, $name, $ingredients, $image, $description, $estimated_cost) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE recipes SET name = ?, image = ?, description = ?, estimated_cost = ? WHERE id = ?');
        $stmt->execute([$name, $image, $description, $estimated_cost, $id]);

        $stmt = $pdo->prepare('DELETE FROM recipe_ingredients WHERE recipe_id = ?');
        $stmt->execute([$id]);

        foreach ($ingredients as $ingredient) {
            $stmt = $pdo->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)');
            $stmt->execute([$id, $ingredient['id'], $ingredient['quantity']]);
        }

        return true;
    }











    public static function get_recipe_by_id($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM recipes  WHERE approved = 1 AND id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function Editget_recipe_by_id($id) {
        global $pdo;
        $query = "SELECT * FROM recipes WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

//    public static function get_favorite_recipes($user_id) {
//        global $pdo;
//        $stmt = $pdo->prepare("
//            SELECT r.* FROM recipes r
//            JOIN favorites f ON r.id = f.recipe_id
//            WHERE f.user_id = ?
//        ");
//        $stmt->execute([$user_id]);
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }
//    public static function add_recipe($user_id,$category_id,$name, $description, $price, $image) {
//        try {
//            global $pdo;
//            $stmt = $pdo->prepare('INSERT INTO recipes (user_id,category_id,name, description, price, image) VALUES (?, ?, ?, ?)');
//            if ($stmt->execute([$user_id,$category_id,$name, $description, $price, $image])) {
//                $recipe_id = $pdo->lastInsertId();
//                if ($recipe_id) {
//                    error_log('Recipe added with ID: ' . $recipe_id);
//                    return $recipe_id;
//                } else {
//                    error_log('Failed to retrieve last insert ID after adding recipe.');
//                }
//            } else {
//                error_log('Failed to execute recipe insertion: ' . implode(', ', $stmt->errorInfo()));
//            }
//        } catch (PDOException $e) {
//            error_log('PDOException: ' . $e->getMessage());
//        }
//        return false;
//    }

    public static function add_recipe($user_id, $category_id, $name, $description, $price, $image) {
        try {
            global $pdo;
            $stmt = $pdo->prepare('INSERT INTO recipes (user_id, category_id, name, description, price, image) VALUES (?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$user_id, $category_id, $name, $description, $price, $image])) {
                return $pdo->lastInsertId();
            } else {
                error_log('Failed to execute recipe insertion: ' . implode(', ', $stmt->errorInfo()));
            }
        } catch (PDOException $e) {
            error_log('PDOException: ' . $e->getMessage());
        }
        return false;
    }

    public static function get_or_create_ingredient($name, $unit) {
        try {
            global $pdo;
            // Check if ingredient already exists
            $stmt = $pdo->prepare('SELECT id FROM ingredients WHERE name = ? AND unit = ?');
            $stmt->execute([$name, $unit]);
            $ingredient = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($ingredient) {
                return $ingredient['id'];
            } else {
                // If ingredient does not exist, create it
                $stmt = $pdo->prepare('INSERT INTO ingredients (name, unit) VALUES (?, ?)');
                if ($stmt->execute([$name, $unit])) {
                    return $pdo->lastInsertId();
                } else {
                    error_log('Failed to execute ingredient insertion: ' . implode(', ', $stmt->errorInfo()));
                }
            }
        } catch (PDOException $e) {
            error_log('PDOException: ' . $e->getMessage());
        }
        return false;
    }

    public static function add_recipe_ingredient($recipe_id, $ingredient_id, $quantity) {
        try {
            global $pdo;
            $stmt = $pdo->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)');
            return $stmt->execute([$recipe_id, $ingredient_id, $quantity]);
        } catch (PDOException $e) {
            error_log('PDOException: ' . $e->getMessage());
        }
        return false;
    }
//    public static function delete_recipe($id) {
//        global $pdo; // Koristi globalni PDO objekat
//
//        try {
//            // Pokreni transakciju
//            $pdo->beginTransaction();
//
//            // Prvo obriši povezane sastojke recepta
//            $stmt = $pdo->prepare('DELETE FROM recipe_ingredients WHERE recipe_id = ?');
//            $stmt->execute([$id]);
//
//            // Zatim obriši recept
//            $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
//            $stmt->execute([$id]);
//
//            // Potvrdi transakciju
//            $pdo->commit();
//            return true;
//        } catch (Exception $e) {
//            // U slučaju greške, vrati transakciju
//            $pdo->rollBack();
//            return false;
//        }
//    }

//    public static function delete_recipe($id) {
//        global $pdo; // Koristi globalni PDO objekat
//
//        try {
//            // Pokreni transakciju
//            $pdo->beginTransaction();
//
//            // Prvo obriši povezane sastojke recepta
//            $stmt = $pdo->prepare('DELETE FROM recipe_ingredients WHERE EXISTS (SELECT 1 FROM recipe_ingredients WHERE recipe_id = ?) AND recipe_id = ?');
//            $stmt->execute([$id, $id]);
//
//            // Obriši povezane komentare
//            $stmt = $pdo->prepare('DELETE FROM comments WHERE EXISTS (SELECT 1 FROM comments WHERE recipe_id = ?) AND recipe_id = ?');
//            $stmt->execute([$id, $id]);
//
//            // Obriši povezane recepte iz menija
//            $stmt = $pdo->prepare('DELETE FROM menu_recipes WHERE EXISTS (SELECT 1 FROM menu_recipes WHERE recipe_id = ?) AND recipe_id = ?');
//            $stmt->execute([$id, $id]);
//
//            // Obriši povezane favorite
//            $stmt = $pdo->prepare('DELETE FROM favorite_recipes WHERE EXISTS (SELECT 1 FROM favorites WHERE recipe_id = ?) AND recipe_id = ?');
//            $stmt->execute([$id, $id]);
//
//            // Zatim obriši recept
//            $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
//            $stmt->execute([$id]);
//
//            // Potvrdi transakciju
//            $pdo->commit();
//            return true;
//        } catch (Exception $e) {
//            // U slučaju greške, vrati transakciju
//            $pdo->rollBack();
//            error_log($e->getMessage()); // Zabeleži grešku u log
//            return false;
//        }
//    }

    public static function delete_recipe($id) {
        global $pdo;
        function deleteRecipeIngredients($id) {
            global $pdo;

            $stmt = $pdo->prepare('DELETE FROM recipe_ingredients WHERE recipe_id = ?');
            $stmt->execute([$id]);
        }

        function deleteRecipeComments($id) {
            global $pdo;

            $stmt = $pdo->prepare('DELETE FROM comments WHERE recipe_id = ?');
            $stmt->execute([$id]);
        }

        function deleteRecipeFromMenus($id) {
            global $pdo;

            $stmt = $pdo->prepare('DELETE FROM menu_recipes WHERE recipe_id = ?');
            $stmt->execute([$id]);
        }

        function deleteRecipeFavorites($id) {
            global $pdo;

            $stmt = $pdo->prepare('DELETE FROM favorites WHERE recipe_id = ?');
            $stmt->execute([$id]);
        }

        function deleteRecipe($id) {
            global $pdo;

            $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
            $stmt->execute([$id]);
        }
        try {
            $pdo->beginTransaction();

            // Call individual delete functions regardless of their outcome
            deleteRecipeIngredients($id);
            deleteRecipeComments($id);
            deleteRecipeFromMenus($id);
            deleteRecipeFavorites($id);
            deleteRecipe($id);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage()); // Log the error
            return false;
        }
    }








    public static function add_to_favorites($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $recipe_id]);
    }

    public static function remove_from_favorites($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?");
        return $stmt->execute([$user_id, $recipe_id]);
    }

    public static function is_favorite($user_id, $recipe_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$user_id, $recipe_id]);
        return $stmt->fetchColumn() !== false;
    }
}
?>