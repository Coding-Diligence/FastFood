<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: black;  
            color: #fff; 
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        nav {
            display: flex;
        }

        a {
            color: #fff; 
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<header>
    <a href="#" class="logo">Logo</a>

    <nav>
        <?php if (!isset($_SESSION['name'])) : ?>
            <a href="front/login.php">Login</a>
            <a href="front/register.php">Register</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['name'])) : ?>
            <a href="logout.php">Bienvenue <?= $_SESSION['name'] ?></a>
        <?php endif; ?>
        <a href="#">Panier</a>
        <a href="logout.php">log</a>
    </nav>
</header>