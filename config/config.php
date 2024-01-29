<?php
    function db() {
        $connexion = null;
        $host = 'localhost';
        $db_name = 'fastfoods';
        $username = 'root';
        $password = '';
        try{
            $connexion = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
            $connexion->exec("set names utf8");
            $_SESSION['db'] = 'Connected';
        }catch(PDOException $exception){
            $_SESSION['db'] = 'disconnected';
            echo "Connection error: " . $exception->getMessage();
        }

        return $connexion;
    }
?>