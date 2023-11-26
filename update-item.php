<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $item_id = $_POST['id'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $bookName = $_POST['book_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check if a new image is uploaded
    if ($_FILES['new_image']['name'] !== '') {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
        $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            // Update image path in the database
            $sql_image = "UPDATE products SET image = '$target_file' WHERE id = '$item_id'";
            if ($conn->query($sql_image) !== TRUE) {
                $_SESSION['update_success'] = false;
                $_SESSION['update_error'] = "Error updating image: " . $conn->error;
                header("Location: userdashboard.php");
                exit();
            }
        } else {
            $_SESSION['update_success'] = false;
            $_SESSION['update_error'] = "Error uploading image.";
            header("Location: userdashboard.php");
            exit();
        }
    }

    // Add the "Condition" field
    $condition = $_POST['condition'];

    // Update other fields in the database, including the "Condition" field
    $sql_update = "UPDATE products 
                   SET author = ?, category = ?, book_name = ?, price = ?, quantity_available = ?, `condition` = ?
                   WHERE id = ?";

    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssdsi", $author, $category, $bookName, $price, $quantity, $condition, $item_id);

    if ($stmt->execute()) {
        // Update successful
        $_SESSION['update_success'] = true;
        header("Location: userdashboard.php");
        exit();
    } else {
        // Update failed
        $_SESSION['update_success'] = false;
        $_SESSION['update_error'] = "Error updating item: " . $stmt->error;
        header("Location: userdashboard.php");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
