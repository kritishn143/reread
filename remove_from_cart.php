<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $userId = $_SESSION['id'];

    // Connect to the database and remove the item from the cart
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM user_cart WHERE user_id = $userId AND product_id = $productId";
    if ($conn->query($sql) === TRUE) {
        // Item removed successfully, you can redirect back to the cart or order summary page
        header('Location: order.php');
    } else {
        echo "Error removing item: " . $conn->error;
    }

    $conn->close();
}
