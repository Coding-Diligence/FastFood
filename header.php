<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        header {
            background-color: #383637;
            color: #fff;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav {
            display: flex;
        }

        a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        #panier-count {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 14px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <a href="index.php">
        <img class="logo" src="./uploads/fastfood_logo.jpg" alt="Logo">
    </a>

    <nav>
        <?php 
        include_once 'database.php';
        include_once 'modele.php';
        ?>
        <?php if (!isset($_SESSION['name'])) : ?>
            <a href="login.php">login</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['name'])) : ?>
            <?php $admin = get_user($_SESSION['name'], $bdLink);
            if (isset($admin['admin']) && $admin['admin'] == 1) : ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <a>Bienvenue <?= $_SESSION['name'] ?></a>
        <?php endif; ?>
        <?php if (isset($_SESSION['name'])) : ?>
            <a href="logout.php">logout</a>
        <?php endif; ?>
        <a href="panier.php">
            Panier
            <span id="panier-count"><?= $_SESSION['nb_items']; ?></span>
        </a>
    </nav>
</header>
</body>
