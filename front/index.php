
<div class="card-container">
    <?php foreach ($products as $p) { ?>
        <div class="card">
            <img src="./uploads/<?= $p['filename']; ?>" class="card-image">
            <div class="card-details">
                <p class="card-title"><?= $p['name']; ?></p>
                <div class="card-actions">
                    <a href="/index.php/product?id=<?= $p['id']; ?>" class="card-link">Voir</a>
                    <small class="card-price"><?= $p['price']; ?>€</small>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<style>
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
    width: 200px;
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