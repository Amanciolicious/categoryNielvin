<?php
session_start();
include("connection.php");

$connection = new Connection();
$con = $connection->OpenConnection(); // Initialize connection

// Handle adding a product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category']; // Stores the cat_id
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];
    $date = $_POST['date'];

    $query = "INSERT INTO product_tbl (product_name, category, price, quantity, product_availability, date) 
              VALUES (:product_name, :category, :price, :quantity, :availability, :date)";
    $query_run = $con->prepare($query);

    $data = [
        ':product_name' => $product_name,
        ':category' => $category,
        ':price' => $price,
        ':quantity' => $quantity,
        ':availability' => $availability,
        ':date' => $date,
    ];

    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['status'] = "Product Added Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Product Not Added";
        header("Location: index.php");
        exit(0);
    }
}

// Handle adding a new category
if (isset($_POST['add_category'])) {
    $cat_name = $_POST['cat_name'];

    $query = "INSERT INTO cat_tbl (cat_name) VALUES (:cat_name)";
    $query_run = $con->prepare($query);

    $data = [
        ':cat_name' => $cat_name,
    ];

    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['status'] = "Category Added Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Category Not Added";
        header("Location: index.php");
        exit(0);
    }
}

?>
