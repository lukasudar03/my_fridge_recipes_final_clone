<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../models/recipe.php';
require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../models/favorite.php';
require_once __DIR__ . '/../utils/email.php';

require_once __DIR__ . '/../assets/vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../assets/vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../assets/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Start output buffering
ob_start();
function send_json_response($success, $message = '', $data = []) {
    // Clean any previous output
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
function get_user_email_by_recipe_id($recipe_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT u.email FROM recipes r JOIN users u ON r.user_id = u.id WHERE r.id = ?');
    $stmt->execute([$recipe_id]);
    $user = $stmt->fetch();
    return $user['email'] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    $action2 = $_GET['action'] ?? null;

    if ($action2 === 'add_favorite') {
        $recipe_id = $_GET['id'];
        if (Favorite::add_favorite($user_id, $recipe_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    if ($action2 === 'remove_favorite') {
        $recipe_id = $_GET['id'];
        if (Favorite::remove_favorite($user_id, $recipe_id)) {

            send_json_response(true);
//echo json_encode(['success' => true]);
        } else {
            send_json_response(false, 'Failed to remove favorite recipe.');
//echo json_encode(['success' => false]);
        }
    }

    if ($action === 'add_recipe') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $category_id = $_POST['category_id'] ?? '';

        $ingredients = $_POST['ingredients'] ?? [];
        $quantities = $_POST['quantities'] ?? [];
        $units = $_POST['units'] ?? [];

        if (!$name || !$description || !$price || !$category_id || empty($ingredients) || empty($quantities) || empty($units)) {
            send_json_response(false, 'All fields are required.');
        }

        $image_name = '';
        if ($_FILES['image']['error'] == 0) {
            $file_temp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $upload_dir = __DIR__ . '/../assets/images/';
            $target_file = $upload_dir . basename($file_name);

            // Provera da li je datoteka slika
            if (!exif_imagetype($file_temp)) {
                send_json_response(false, 'File is not an image.');
            }

            // Kreiranje direktorijuma ako ne postoji
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }

            // Pomeranje datoteke u ciljani direktorijum
            if (move_uploaded_file($file_temp, $target_file)) {
                $image_name = $file_name;
            } else {
                send_json_response(false, 'Error moving uploaded file.');
            }
        }

        if (!$image_name) {
            send_json_response(false, 'Image upload failed.');
        }

        $recipe_id = Recipe::add_recipe($user_id, $category_id, $name, $description, $price, $image_name);

        if ($recipe_id) {
            $success = true;
            foreach ($ingredients as $index => $ingredient_name) {
                $ingredient_id = Recipe::get_or_create_ingredient($ingredient_name, $units[$index]);
                if (!$ingredient_id || !Recipe::add_recipe_ingredient($recipe_id, $ingredient_id, $quantities[$index])) {
                    $success = false;
                    send_json_response(false, 'Failed to add ingredient: ' . $ingredient_name);
                }
            }
            if ($success) {
                send_json_response(true, 'Recipe added successfully.');
            } else {
                send_json_response(false, 'Failed to add ingredients.');
            }
        } else {
            send_json_response(false, 'Failed to add recipe.');
        }
    }


    if ($action === 'create_recipe') {
        $name = $_POST['name'] ?? '';
        $ingredients = json_decode($_POST['ingredients'], true) ?? [];
        $description = $_POST['description'] ?? '';
        $estimated_cost = $_POST['estimated_cost'] ?? '';

        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image);
        }

        if (empty($name) || empty($ingredients) || empty($description) || empty($estimated_cost)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        $recipe_id = Recipe::create_recipe($name, $ingredients, $image, $description, $estimated_cost);
        echo json_encode(['success' => (bool)$recipe_id]);
    }
    elseif ($action === 'update_recipe') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $ingredients = json_decode($_POST['ingredients'], true) ?? [];
        $description = $_POST['description'] ?? '';
        $estimated_cost = $_POST['estimated_cost'] ?? '';

        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image);
        } else {
            $image = $_POST['existing_image'] ?? '';
        }

        if (empty($id) || empty($name) || empty($ingredients) || empty($description) || empty($estimated_cost)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            exit();
        }

        $result = Recipe::update_recipe($id, $name, $ingredients, $image, $description, $estimated_cost);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'delete_recipe') {
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Recipe ID is required.']);
            exit();
        }
        $result = Recipe::delete_recipe($id);
        echo json_encode(['success' => $result]);
    } elseif ($action === 'approve_recipe') {
        require_admin();
        $recipe_id = $_POST['id'] ?? null;

        if ($recipe_id && Recipe::approve_recipe($recipe_id)) {
            send_json_response(true, 'Recipe approved successfully.');
        } else {
            send_json_response(false, 'Failed to approve recipe.');
        }
    } elseif ($action === 'reject_recipe') {
        require_admin();

        $recipe_id = $_POST['id'] ?? null;
        $reason = $_POST['reason'] ?? '';

        if ($recipe_id && Recipe::reject_recipe($recipe_id, $reason)) {
            $user_email = get_user_email_by_recipe_id($recipe_id);
            if ($user_email) {
                send_email($user_email, "Your recipe has been rejected", "Your recipe has been rejected for the following reason: $reason");
            }
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }

}
?>
