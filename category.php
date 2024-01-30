<?php 
include_once 'modele.php';
$categories = get_categories($bdLink);
?>

<div class="card-container">
    <?php foreach ($categories as $c) { ?>
        <a href="<?= $c['name']; ?>.php" class="card-link"> 
            <div class="card">
                <img src="./uploads/<?= $c['name']; ?>" class="card-image">
                <div class="card-details">
                    <p class="card-title"><?= $c['name']; ?></p>
                    <div class="card-actions">
                    </div>
                </div>
            </div>
        </a> 
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

.card-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
}

.card-link {
    text-decoration: none;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    display: block; 
}

.card-price {
    font-size: 14px;
    color: #888;
}
</style>
<?php require_once 'footer.php'; ?>