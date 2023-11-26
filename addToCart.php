<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo 'Please log in to add items to your cart.';
    exit;
}

// Check for POST data (product ID and quantity)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId']) && isset($_POST['quantity'])) {
        $productId = $_POST['productId'];
        $quantity = intval($_POST['quantity']);

        // Validate the product ID and quantity
        if ($productId <= 0 || $quantity <= 0) {
            echo 'Invalid product ID or quantity.';
            exit;
        }

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM user_cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $userId, $productId);
        $userId = $_SESSION['id'];
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Item is already in the cart, update the quantity
            $stmt = $conn->prepare("UPDATE user_cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $userId, $productId);

            if ($stmt->execute()) {
                echo 'Item added to your cart.';
            } else {
                echo 'Error updating cart: ' . $stmt->error;
            }
        } else {
            // Item is not in the cart, insert a new row
            $stmt = $conn->prepare("INSERT INTO user_cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $userId, $productId, $quantity);

            if ($stmt->execute()) {
                echo 'Item added to your cart.';
            } else {
                echo 'Error adding to cart: ' . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
