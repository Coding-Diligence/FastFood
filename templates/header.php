<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="config/session_destroy.php">Destroy</a>
    <?php if (!isset($_SESSION['names'])): ?>
        <a href="config/login_register.php">Login</a>
    <?php endif;?>
    <?php if (isset($_SESSION['names'])): ?>
        <a href="config/session_destroy.php">Bienvenue <?= $_SESSION['names']?></a>
    <?php endif;?>
</body>
</html>