<?php
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    // Dodajte svoje uslove za validaciju lozinke
    return strlen($password) >= 6;
}
?>
