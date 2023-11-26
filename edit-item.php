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
    // Fetch the item from the database using the id
    $sql_item = "SELECT * FROM products WHERE id = '$id'";
    $result_item = $conn->query($sql_item);
    $row_item = $result_item->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REREAD</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="edit-item.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="video/reread.ico" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="top-left">
                    <a href="index.php">
                        <img src="video/logo.gif" alt="REREAD Logo" width="40" height="40">
                        <em>REREAD</em>
                    </a>
                </li>
                <li class="search-bar">
                    <form action="search.php" method="GET" class="search-form">
                        <input type="text" name="search_query" placeholder="Search for books...">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
                        </button>
                    </form>
                </li>
                <li class="top-right">
                    <?php if (isset($_SESSION['id'])) : ?>
                        <a href="userdashboard.php"><?php echo ucfirst(strtolower($_SESSION['user_name'])); ?></a>
                    <?php else : ?>
                        <a href="<?php echo $loginLink; ?>" class="login-button">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <form id="update-item-form" action="update-item.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row_item['id']; ?>">
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" value="<?php echo $row_item['author']; ?>" required>
        </div>
        <div class="form-group">
            <label for="condition">Condition:</label>
            <select name="condition" id="condition" required>
                <option value="New" <?php if ($row_item['condition'] == 'New') echo 'selected'; ?>>New</option>
                <option value="Like New" <?php if ($row_item['condition'] == 'Like New') echo 'selected'; ?>>Like New</option>
                <option value="Excellent" <?php if ($row_item['condition'] == 'Excellent') echo 'selected'; ?>>Excellent</option>
                <option value="Good" <?php if ($row_item['condition'] == 'Good') echo 'selected'; ?>>Good</option>
                <option value="Fair" <?php if ($row_item['condition'] == 'Fair') echo 'selected'; ?>>Fair</option>
                <option value="Poor" <?php if ($row_item['condition'] == 'Poor') echo 'selected'; ?>>Poor</option>
                <!-- Add more condition options as needed -->
            </select>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="Biographies" <?php if ($row_item['category'] == 'Biographies') echo 'selected'; ?>>Biographies</option>
                <option value="Children's Books" <?php if ($row_item['category'] == "Children's Books") echo 'selected'; ?>>Children's Books</option>
                <option value="Education & Reference" <?php if ($row_item['category'] == 'Education & Reference') echo 'selected'; ?>>Education & Reference</option>
                <!-- Add more options for other categories -->
            </select>
        </div>
        <div class="form-group">
            <label for="book_name">Book Name:</label>
            <input type="text" name="book_name" id="book_name" value="<?php echo $row_item['book_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="new_image">New Image:</label>
            <input type="file" name="new_image" id="new_image" accept="image/*">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" min="0.01" step="0.01" value="<?php echo $row_item['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity Available:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="<?php echo $row_item['quantity_available']; ?>" required>
        </div>
        <input type="submit" name="submit" value="Update">
    </form>

    <section class="footer-bar">
        <div class="footer-logo"> 
            <img src="video/logo.gif" alt="REREAD Logo" width="100">
            <p>Rediscover the Magic of Books.</p>
        </div>
        <div class="helpful-links">
            <h1>Helpful Links</h1>
            <ul>
                <li><a href="about.php" >About us</a></li>
               
            </ul>
        </div>
        <div class="contact-info">
            <h1>Contact Us</h1>
            <p>Email: reread@gmail.com</p>
            <p>Phone: +123456789</p>
        </div>
        <div class="social-links">
            <h1>Follow Us</h1>
            <ul>
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <!-- Add more social media links/icons as needed -->
            </ul>
        </div>
    </section>

    <!-- Your PHP code for the "update-item.php" form goes here -->

    <footer>
        <p>&copy; <?php echo date('Y'); ?> REREAD. All rights reserved</p>
    </footer>
</body>
</html>
