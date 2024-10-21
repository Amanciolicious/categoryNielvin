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

    $query = "INSERT INTO product_table (product_name, category, price, quantity, product_availability, date) 
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

// Handle updating a product
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];
    $date = $_POST['date'];

    // Prepare the update query
    $query = "UPDATE product_table SET product_name = :product_name, category = :category, price = :price, quantity = :quantity, product_availability = :availability, date = :date WHERE id = :product_id";
    $query_run = $con->prepare($query);

    $data = [
        ':product_id' => $product_id,
        ':product_name' => $product_name,
        ':category' => $category,
        ':price' => $price,
        ':quantity' => $quantity,
        ':availability' => $availability,
        ':date' => $date,
    ];

    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['status'] = "Product Updated Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Product Not Updated";
        header("Location: index.php");
        exit(0);
    }
}


// Handle adding a new category
if (isset($_POST['add_category'])) {
    $category_name = $_POST['cat_name'];

    $query = "INSERT INTO category_table (category_name) VALUES (:category_name)";
    $query_run = $con->prepare($query);

    $data = [
        ':category_name' => $category_name,
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
// Handle deleting a product
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $query = "DELETE FROM product_table WHERE id = :product_id";
    $query_run = $con->prepare($query);

    $data = [
        ':product_id' => $product_id,
    ];

    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['status'] = "Product Deleted Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Product Not Deleted";
        header("Location: index.php");
        exit(0);
    }
}

?>
