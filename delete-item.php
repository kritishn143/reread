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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Delete the item from the database using the id
    $sql_delete = "DELETE FROM products WHERE id = '$id'";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: userdashboard.php");
        exit();
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}
?>
