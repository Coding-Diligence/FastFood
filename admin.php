<?php
include_once 'database.php';
include_once 'modele.php';
include_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $categoryName = $_POST['category_name'];

        $uploadedFile = isset($_FILES['category_image']) ? $_FILES['category_image'] : null;
        $filename = upload_file($uploadedFile, $categoryName);

        if ($filename) {
            set_category(['name' => $categoryName], $bdLink);
            echo "Category added successfully!";
        } else {
            echo "Error uploading category image.";
        }
    } elseif (isset($_POST['remove_category'])) {
        $categoryId = $_POST['category_id'];

        remove_category($categoryId, $bdLink);
        echo "Category removed successfully!";
    }
}

$categories = get_categories($bdLink);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $productData = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'category' => $_POST['category'],
    ];

    $imageFile = $_FILES['file'];

    if (empty($productData['name']) || empty($productData['description']) || empty($productData['price']) || empty($productData['category']) || empty($imageFile)) {
        echo "Please fill in all the fields.";
    } else {
        $categoryName = get_category_name($productData['category'], $bdLink);
        
        if ($categoryName !== null) {
            set_product($productData, $imageFile, $categoryName, $bdLink);
            echo "Product added successfully!";
        } else {
            echo "Category not found.";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product'])) {
    $productId = $_POST['product_id'];

    if (!empty($productId)) {
        remove_product($productId, $bdLink);
        echo "Product removed successfully!";
    } else {
        echo "Please select a product to remove.";
    }
}
?>

<body>
    <h1 class="avec">Admin Panel</h1>
        <div class="avec">
            <h2>Add Category</h2>
            <form method="post" enctype="multipart/form-data">
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" required>
                <label for="category_image">Category Image:</label>
                <input type="file" name="category_image" accept="image/jpeg, image/png" required>
                <input type="submit" name="add_category" value="Add Category">
            </form>
        </div>

        <div class="avec">
            <h2>Remove Category</h2>
            <form method="post">
                <label for="category_id">Select Category:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="remove_category" value="Remove Category">
            </form>
        </div>

        <div class="avec">
            <h2>Categories</h2>
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li><?= $category['name']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

<!-- ================================================================================================================= -->

        <form method="post" action="admin.php" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>

            <label for="description">Product Description:</label>
            <textarea name="description" required></textarea>

            <label for="price">Product Price:</label>
            <input type="text" name="price" required>

            <label for="category">Product Category:</label>
            <select name="category" required>
                <?php
                $categories = get_categories($bdLink);
                foreach ($categories as $category) {
                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
                ?>
            </select>

            <label for="product_image">Product Image:</label>
            <input type="file" name="product_image" accept="image/*" required>

            <input type="submit" name="add_product" value="Add Product">
        </form>
        <form method="post" action="admin.php">
            <h2>Remove Product</h2>
            <label for="product_id">Select Product:</label>
            <select name="product_id" required>
                <?php
                $products = get_products($bdLink);
                foreach ($products as $product) {
                    echo "<option value='{$product['id']}'>{$product['name']}</option>";
                }
                ?>
            </select>

            <input type="submit" name="remove_product" value="Remove Product">
        </form>
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #181B1E;
        color: white;
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
    form, .avec {
        border: 4mm ridge #383637;
        background-color: #181B1E;
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 8px;
        max-width: 400px;
        margin: 20px auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</html>
