<?php
function get_products_by_category($id, $bdLink) {
    $query = "SELECT * FROM product WHERE category=:id";
    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
}

function get_products_by_id($id, $bdLink) {
    $query = "SELECT * FROM product WHERE id=:id";
    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    return $product;
}

function get_products($bdLink) {
    $query = "SELECT * FROM product";
    $stmt = $bdLink->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
}

function get_categories($bdLink) {
    $query = "SELECT * FROM category";
    $stmt = $bdLink->prepare($query);
    $stmt->execute();

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
}
function get_user($username, $bdLink) {
    $query = "SELECT * FROM user WHERE name=:username";
    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}
function upload_file($file, $categoryName) {
    if (!$file || $file['error'] !== 0) {
        return false;
    }

    $uploadDir = __DIR__ . '/uploads/';
    
    // Ensure the uploads directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate the filename based on the category name
    $filename = strtolower(str_replace(' ', '_', $categoryName)) . '.jpg';
    $uploadPath = $uploadDir . $filename;

    // Move the uploaded file to the specified path
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return $filename;
    }

    return false;
}

function set_product($data, $files, $categoryName, $bdLink) {
    $query = "INSERT INTO product SET name=:name, description=:description, price=:price, category=:category, filename=:filename";

    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(":name", $data['name']);
    $stmt->bindParam(":description", $data['description']);
    $stmt->bindParam(":price", $data['price']);
    $stmt->bindParam(":category", $data['category']);

    $filename = upload_file($files, $categoryName);
    $stmt->bindParam(":filename", $filename);
    
    $stmt->execute();
}
function set_category($data, $bdLink) {
    $query = "INSERT INTO category SET name=:name";

    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(":name", $data['name']);
    $stmt->execute();
}
function remove_category($id, $bdLink) {
    $query = "DELETE FROM category WHERE id=" . $id;

    $stmt = $bdLink->prepare($query);
    $stmt->execute();
}
function remove_product($id, $bdLink) {
    $query = "DELETE FROM product WHERE id=" . $id;

    $stmt = $bdLink->prepare($query);
    $stmt->execute();
}
function set_user($data, $bdLink) {
    $query = "INSERT INTO user SET email=:email, password=:password, admin=:admin";

    $stmt = $bdLink->prepare($query);
    $email = $data['email'];
    $password = md5($data['password']);
    $admin = (isset($data['admin'])) ? 1 : 0;
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":admin", $admin);
    $stmt->execute();
}
function remove_user($id, $bdLink) {
    $query = "DELETE FROM user WHERE id=" . $id;

    $stmt = $bdLink->prepare($query);
    $stmt->execute();
}
function get_category_name($categoryId, $bdLink) {
    $query = "SELECT name FROM category WHERE id = :id";
    $stmt = $bdLink->prepare($query);
    $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['name'];
    } else {
        return null;
    }
}

?>
