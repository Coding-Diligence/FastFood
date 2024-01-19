<?php

switch ($_SERVER['SERVER_NAME']) {
    case '127.0.0.1':
    case 'localhost':
        define('ENVIRONMENT', 'developpement');
        $paramsServer = array(
            'server'    => "localhost",
            'database'  => "fastfood",
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
