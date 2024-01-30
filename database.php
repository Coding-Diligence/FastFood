<?php
switch ($_SERVER['SERVER_NAME']) {
    case '127.0.0.1':
    case 'localhost':
        define('ENVIRONMENT', 'developpement');

        $paramsServer = array(
            'server'    => "localhost",
            'database'  => "fastfoods",
            'username'  => "root",
            'password'  => "",
            'port' => 3306,
        );

        define('PREFIX', '');
        define('DNS', 'https://portfolio.test/' . PREFIX);
        define('HOME', $_SERVER['CONTEXT_DOCUMENT_ROOT']);

        define('PATH_FILES', "files/");

        break;

    default:
        define('ENVIRONMENT', 'production');

        $paramsServer = array(
            'server' => "portfolio.mysql.db",
            'database' => "portfolio",
            'username' => "portfolio",
            'password' => "xxxxxxxxxxx",
            'port' => 3306
        );

        define('PREFIX', '');
        define('DNS', 'https://www.portfolio.fr/' . PREFIX);
        define('HOME', $_SERVER['DOCUMENT_ROOT']);

        define('PATH_FILES', "files/");
        exit;
        
}
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['nb_items'] = 0;
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} 
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = 'disconnected';
} 
try {
    $bdLink = new PDO('mysql:host=' . $paramsServer['server'] . ';port=' . $paramsServer['port'] . ';dbname=' . $paramsServer['database'] . ';charset=utf8', $paramsServer['username'], $paramsServer['password']);
    $bdLink->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $bdLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION['db'] = 'Database Connected';
} catch (PDOException $e) {
    $_SESSION['db'] = 'Error!';
    die();
}
