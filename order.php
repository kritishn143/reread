<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

// Initialize variables to store order total and items
$totalPrice = 0;
$cartItems = [];

// Connect to the database (Replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve cart items for the logged-in user
$userId = $_SESSION['id'];
$sql = "SELECT products.*, user_cart.quantity FROM products
        INNER JOIN user_cart ON products.id = user_cart.product_id
        WHERE user_cart.user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalPrice += $row['price'] * $row['quantity'];
        $cartItems[] = $row;
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Reread</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="order.css">
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
    <li><a href="index.php">Home</a></li>
            <li><a href="upload.php" style="margin-left: 10px;">Upload</a></li>
            <li><a href="order.php" style="margin-left: 10px;">Carts</a></li>
            <li class="top-right"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h1>Order Summary</h1>

    <?php if (empty($cartItems)) : ?>
        <p>No recent orders</p>
    <?php else : ?>
        <div class="order-summary">
            <table>
    <thead>
        <tr>
            <th>Book Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($cartItems as $item) : ?>
    <tr>
        <td><?php echo $item['book_name']; ?></td>
        <td><?php echo $item['price']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td><?php echo $item['price'] * $item['quantity']; ?></td>
        <td>
            <form action="remove_from_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                <input type="submit" value="Remove">
            </form>
        </td>
    </tr>
<?php endforeach; ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total:</th>
            <td><?php echo $totalPrice; ?></td>
        </tr>
    </tfoot>
</table>
</div>

        <div class="order-actions">
            <form action="place_order.php" method="post">
                <!-- Add any additional fields for the order (e.g., shipping address) here -->
                <input type="submit" value="Place Order">
            </form>
        </div>
    <?php endif; ?>


    <section class="footer-bar">
        <div class="footer-logo"> 
            <img src="video/logo.gif" alt="REREAD Logo" width="100">
            <p>Rediscover the Magic of Books.</p>
        </div>
        <div class="helpful-links">
            <h1>Helpful Links</h1>
            <ul>
                <li><a href="about.php">About us</a></li>
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
            
            </ul>
        </div>
    </section>
 <footer>
        <p>&copy; <?php echo date('Y'); ?> REREAD. All rights reserved</p>
    </footer>
</body>
</html>
