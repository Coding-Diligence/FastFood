<?php
// panier_update.php

// Simulate updating panier count (replace this with your logic to fetch the actual count)
$panierCount = isset($_SESSION['nb_items']) ? $_SESSION['nb_items'] : 0;

// Return the count as JSON
header('Content-Type: application/json');
echo json_encode(['count' => $panierCount]);
?>
