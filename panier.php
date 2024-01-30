<?php
include_once 'database.php';
include_once 'modele.php';
include_once 'header.php';

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_panier'])) {
    $productId = $_POST['product_id'];

    foreach ($panier as $key => $item) {
        if ($item['id'] == $productId) {
            $_SESSION['nb_items']--;
            unset($panier[$key]);
            break;
        }
    }

    $_SESSION['panier'] = array_values($panier);
}
?>

<div class="card-container">
    <?php
    $totalPrice = 0; // Initialize total price
    foreach ($panier as $item) {
        $totalPrice += $item['price']; // Add each item's price to the total
        ?>
        <div class="card">
            <img src="./uploads/<?= $item['filename']; ?>" class="card-image">
            <div class="card-details">
                <p class="card-title"><?= $item['name']; ?></p>
                <div class="card-actions">
                    <form method="post" action="panier.php">
                        <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                        <input type="submit" name="remove_from_panier" value="Remove" class="card-link">
                    </form>
                    <small class="card-price"><?= $item['price']; ?>€</small>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div>
    <h3>Total Price: <?= $totalPrice; ?>€</h3>
</div>

<style>
    html {
        background-color: #181B1E;
        color: white;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin: 10px;
        margin-bottom: 100px;
        padding: 10px;
        width: 400px;
        text-align: center;
    }

    .card-image {
        width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .card-details {
        margin-top: 10px;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
    }

    .card-link {
        text-decoration: none;
        background-color: #dc3545; 
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .card-price {
        font-size: 14px;
        color: #888;
    }
</style>
<?php require_once 'footer.php'; ?>