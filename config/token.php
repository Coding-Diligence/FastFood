<?php
// Look for a token in the session
if (!isset($_SESSION['csrf_token'])) {
    echo "CSRF token not found in the session.";
    exit();
}

// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     echo "CSRF token validation failed.";
//     exit();
// }