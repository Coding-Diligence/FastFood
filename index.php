<style>
<?php include 'src/style/style.css'; ?>
</style>
<?php
require_once 'templates/header.php';
require_once 'config/system.php';
try {
    $bdLink = new PDO('mysql:host=' . $paramsServer['server'] . ';port=' . $paramsServer['port'] . ';dbname=' . $paramsServer['database'] . ';charset=utf8', $paramsServer['username'], $paramsServer['password']);
    $bdLink->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $bdLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    print 'Connection done';
} catch (PDOException $e) {
    print "Error ! database connection error<br/>";
    die();
}