<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST["author"];
    $condition = $_POST["condition"];  // Updated to handle the "condition" field
    $category = $_POST["category"];
    $bookName = $_POST["book_name"];
    $price = floatval($_POST["price"]); // Convert to float for price
    $quantity = intval($_POST["quantity"]); // Convert to integer for quantity

    // Retrieve user information from the session
    $uploaded_by = $_SESSION['user_name'];  // Modify this based on your session variable name

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/local/images/uploads/"; // Adjust the path according to your project structure

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory with proper permissions
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (author, `condition`, category, image, book_name, uploaded_by, price, quantity_available) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssdd", $author, $condition, $category, $target_file, $bookName, $uploaded_by, $price, $quantity);

        if ($stmt->execute()) {
            echo '<script>alert("Upload successful!");';
            echo 'window.location.href = "userdashboard.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error moving the uploaded file.";
    }
}

$conn->close();
?>
