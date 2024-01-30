<?php
include_once 'database.php';
include_once 'modele.php';
include_once 'header.php';

$products = get_products_by_category(2, $bdLink);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_panier'])) {
    $productId = $_POST['product_id'];
    $product = get_products_by_id($productId, $bdLink);

    if ($product) {
        $_SESSION['nb_items']++;
        $_SESSION['panier'][] = $product;
    }
}
?>

<div class="card-container">
    <?php foreach ($products as $p) { ?>
        <div class="card">
            <img src="./uploads/<?= $p['filename']; ?>" class="card-image">
            <div class="card-details">
                <p class="card-title"><?= $p['name']; ?></p>
                <p class="card-description"><?= $p['description']; ?></p>
                <div class="card-actions">
                    <form method="post" action="pizza.php">
                        <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                        <input type="submit" name="add_to_panier" value="Add" class="card-link">
                    </form>
                    <small class="card-price"><?= $p['price']; ?>€</small>
                </div>
            </div>
        </div>
    <?php } ?>
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

    .card-description {
        font-size: 14px;
        color: #ccc;
    }

    .card-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
    }

    .card-link {
        text-decoration: none;
        background-color: #007bff;
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