<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} 
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = 'disconnected';
} 
if (!isset($_SESSION['db'])) {
    require_once dirname(__DIR__) . '/../config/config.php';
    db();
}

