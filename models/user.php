<?php
class User {
    public static function register($email, $password, $first_name, $last_name, $phone, $token) {
        global $pdo;
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, phone, registration_token) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$email, $hash, $first_name, $last_name, $phone, $token]);
    }

    public static function login($email, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user["is_verified"]==0){
            return false;
        }

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['phone'] = $user['phone'];
            return true;
        }

        return false;
    }

    public static function update_profile($user_id, $first_name, $last_name, $phone, $password = null) {
        global $pdo;
        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, password = ? WHERE id = ?");
            return $stmt->execute([$first_name, $last_name, $phone, $hash, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ? WHERE id = ?");
            return $stmt->execute([$first_name, $last_name, $phone, $user_id]);
        }
    }



    public static function delete_user($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function set_reset_token($email, $token) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        return $stmt->execute([$token, $email]);
    }

    public static function reset_password($token, $new_pwd){
        global $pdo;
        $stmt = $pdo->prepare("SELECT 1 FROM users where reset_token = ?");
        $stmt->execute([$token]);
        $isvalid = $stmt->fetchColumn(0);
        if(!$isvalid){
            return false;
        }
        $stmt = $pdo->prepare("UPDATE users set password=?, reset_token=? WHERE reset_token=?");
        return (boolean)$stmt->execute([password_hash($new_pwd, PASSWORD_BCRYPT), null, $token]);
    }

    // models/User.php
    public static function create_user($email, $password, $activation_token) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO users (email, password, activation_token) VALUES (?, ?, ?)');
        if ($stmt->execute([$email, $password, $activation_token])) {
            return $pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public static function get_user_by_email($email) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function get_user_by_activation_token($token) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE activation_token = ?');
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function activate_user($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET activation_token = NULL, active = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }
// models/User.php
    public static function block_user($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET is_active = 1 WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function unblock_user($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET is_active = 0 WHERE id = ?');
        return $stmt->execute([$id]);
    }
    public static function update_user($user_id, $first_name, $last_name, $phone, $hashed_password = null) {
        global $pdo;
        try {
            $pdo->beginTransaction();
            $query = 'UPDATE users SET first_name = ?, last_name = ?, phone = ?';
            $params = [$first_name, $last_name, $phone];

            if ($hashed_password) {
                $query .= ', password = ?';
                $params[] = $hashed_password;
            }

            $query .= ' WHERE id = ?';
            $params[] = $user_id;

            $stmt = $pdo->prepare($query);
            $result = $stmt->execute($params);
            $pdo->commit();

            return $result;
        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    public static function get_all_blocked_users() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE is_active = 1 AND role="user"');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function get_all_unblocked_users() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM users WHERE is_active = 0 AND role="user" ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function check_user_active_status($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT is_active FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function authenticate($email, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
?>
