<?php
include("connection.php"); 

// Create a new instance of the Connection class and open the connection
$connection = new Connection();
$pdo = $connection->OpenConnection();

function searchProducts($pdo) {
    $sql = "SELECT p.*, c.category_name FROM product_table p 
            INNER JOIN category_table c ON p.category = c.cat_id WHERE 1";

    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $product_availability = isset($_POST['product_availability']) ? $_POST['product_availability'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

    // Add conditions based on input
    if (!empty($product_name)) {
        $sql .= " AND p.product_name LIKE :product_name";
    }

    if (!empty($category)) {
        $sql .= " AND p.category = :category";
    }

    if (!empty($product_availability)) {
        $sql .= " AND p.product_availability = :product_availability";
    }

    if (!empty($start_date) && !empty($end_date)) {
        $sql .= " AND p.date BETWEEN :start_date AND :end_date";
    }

    $sql .= " ORDER BY p.id ASC";

    // Prepare and bind parameters
    $stmt = $pdo->prepare($sql);

    if (!empty($product_name)) {
        $product_name = "%" . $product_name . "%";
        $stmt->bindParam(':product_name', $product_name);
    }

    if (!empty($category)) {
        $stmt->bindParam(':category', $category);
    }

    if (!empty($product_availability)) {
        $stmt->bindParam(':product_availability', $product_availability);
    }

    if (!empty($start_date) && !empty($end_date)) {
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
    }

    // Execute the query
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Call the search function if the search button is pressed
$result = [];
if (isset($_POST['search'])) {
    $result = searchProducts($pdo);
} else {
    // If no search criteria are selected, fetch all data
    $stmt = $pdo->query("SELECT p.*, c.category_name FROM product_table p 
                          INNER JOIN category_table c ON p.category = c.cat_id");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Close the connection
$connection->closeConnection();
?>
