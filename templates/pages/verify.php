<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../config/db_config.php';
$token = $_GET['token'];

global $pdo;
$stmt = $pdo->prepare('UPDATE users set is_verified=?, registration_token=? WHERE registration_token=?');
$stmt->execute([1, null, $token]);
?>
<div class="container">
    <?php if($stmt->rowCount()>0): ?>
    Account succesfully verified.
    <?php else: ?>
    Something went wrong while verifying account.
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
