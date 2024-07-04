<?php
// utils/token.php

function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

function validate_token($token, $stored_token) {
    return hash_equals($token, $stored_token);
}

?>