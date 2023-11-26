<?php
session_start();
$loginLink = "login.php";
$signUpLink = "signup.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Retrieve book details based on the provided book ID
    $sql_book_details = "SELECT * FROM products WHERE id = $bookId";
    $result_book_details = $conn->query($sql_book_details);

    if ($result_book_details->num_rows > 0) {
        $book = $result_book_details->fetch_assoc();
    } else {
        // Handle the case where the book ID is not found
        // You can redirect or display an error message
        // For example:
        echo "Book not found.";
        exit;
    }
} else {
    // Handle the case where no book ID is provided
    // You can redirect or display an error message
    // For example:
    echo "Book ID is missing.";
    exit;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="video/reread.ico" type="image/x-icon">
    <title><?php echo $book['book_name']; ?> | Reread</title>
    <link rel="stylesheet" href="book_details.css">
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

    <section class="book-details">
    <h1><?php echo $book['book_name']; ?></h1>

    <img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $book['image']); ?>" alt="Book Cover">    <p>Price: NPR <?php echo $book['price']; ?></p>
    <p>Author: <?php echo $book['author']; ?></p>
    <p>Category: <?php echo $book['category']; ?></p>
    
    <p>Uploaded by: <?php echo $book['uploaded_by']; ?></p>
    <p>Available Quantity: <?php echo $book['quantity_available']; ?></p>

    <!-- "Buy" button for purchasing the book -->
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $book['quantity_available']; ?>">
    <button class="add-to-cart" data-product-id="<?php echo $book['id']; ?>">Buy</button>
</section>


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

    <footer>
        <p>&copy; <?php echo date('Y'); ?> REREAD. All rights reserved</p>
    </footer>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.add-to-cart').addEventListener('click', function (event) {
        event.preventDefault();
        const quantityInput = document.querySelector('#quantity');
        const quantity = parseInt(quantityInput.value, 10);
        const productId = event.target.getAttribute('data-product-id');

        if (isNaN(quantity) || quantity < 1) {
            alert('Please enter a valid quantity (1 or more).');
        } else if (quantity > parseInt(quantityInput.getAttribute('max'), 10)) {
            alert('Quantity exceeds the available quantity.');
        } else {
            // Check if the user is logged in (you can add your own condition)
            <?php if (isset($_SESSION['id'])) : ?>
                const confirmation = confirm('Add ' + quantity + ' item(s) to your cart?');
                if (confirmation) {
                    // User is logged in, send the selected quantity and product ID to the server
                    addToCart(productId, quantity);
                }
            <?php else : ?>
                // User is not logged in, you can add your own logic (e.g., redirect to the login page)
                alert('You need to be logged in to make a purchase.');
            <?php endif; ?>
        }
    });

    function addToCart(productId, quantity) {
        const xhr = new XMLHttpRequest();
    xhr.open('POST', 'addToCart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server (e.g., display a success message)
            alert(xhr.responseText);
        }
    };

    const data = 'productId=' + productId + '&quantity=' + quantity;
    xhr.send(data);
    }
});
</script>
