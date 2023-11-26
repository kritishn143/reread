<?php
session_start();
$loginLink = "login.php";
$signUpLink = "signup.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";
$booksPerPage = 8; // Adjust the number of books per page as needed
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['book_id'])) {
    // Retrieve book details based on the clicked book's ID
    $bookId = $_GET['book_id'];
    $sql_book_details = "SELECT * FROM products WHERE id = $bookId";
    $result_book_details = $conn->query($sql_book_details);

    if ($result_book_details->num_rows > 0) {
        $book = $result_book_details->fetch_assoc();
        // You can now display the book details on the "book_details.php" page.
        header("Location: book_details.php?book_id=$bookId");
        exit;
    }
}

$logged_in_user = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

$sql_gallery = "SELECT * FROM products WHERE uploaded_by <> '$logged_in_user'";
$result_gallery = $conn->query($sql_gallery);

// Calculate the total number of books
$totalBooks = $result_gallery->num_rows;
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

    <section class="filter-section">
        <h2>Filter Books by Category</h2>
        <ul class="filter-list">
            <li><a href="#" data-category="all">All</a></li>
            <li><a href="#" data-category="Biographies">Biographies</a></li>
            <li><a href="#" data-category="Children's Books">Children's Books</a></li>
            <li><a href="#" data-category="Education & Reference">Education & Reference</a></li>
            
            <!-- Add more filter options for other categories -->
        </ul>
    </section>

    <section class="book-section">
    <h2>Available Books</h2>
    <div class="book-cards">
        <?php
        $categories = array(); // Store unique categories

        // First, retrieve unique categories
        $sql_categories = "SELECT DISTINCT category FROM products";
        $result_categories = $conn->query($sql_categories);

        if ($result_categories->num_rows > 0) {
            while ($row = $result_categories->fetch_assoc()) {
                $categories[] = $row['category'];
            }
        }

        // Iterate through categories and fetch random books
        foreach ($categories as $category) {
            // Escape the apostrophe in the category name
            $escapedCategory = $conn->real_escape_string($category);
        
            $sql_books = "SELECT products.*, users.full_name FROM products 
                          LEFT JOIN users ON products.uploaded_by = users.user_name
                          WHERE products.category = '$escapedCategory' 
                          LIMIT 8"; // Removed "ORDER BY RAND()"
            $result_books = $conn->query($sql_books);
        
            if ($result_books->num_rows == 0) {
                echo "<p>Currently no books are available in the '$category' category.</p>";
            } else {
                while ($row = $result_books->fetch_assoc())  {
                    ?>
                    <div class="book-card" data-category="<?php echo $row['category']; ?>">
    <img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $row['image']); ?>" alt="Book Cover">
    <p>Price: NPR<?php echo $row['price']; ?></p>
    <p>Condition: <?php echo $row['condition']; ?></p> 
    <h3><a href="gallery.php?book_id=<?php echo $row['id']; ?>">
        <?php echo $row['book_name']; ?>
    </a></h3>
    <p>Author: <?php echo $row['author']; ?></p>
    <p>Available Quantity: <?php echo $row['quantity_available']; ?></p>
</div>

                    <?php
                }
            }
        }
       
        ?>
    </div>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterLinks = document.querySelectorAll(".filter-list a");
        const bookCards = document.querySelectorAll(".book-card");

        // Function to show all book cards
        function showAllBooks() {
            bookCards.forEach((card) => {
                card.style.display = "block";
            });
        }

        // Initial display: Show all books
        showAllBooks();

        filterLinks.forEach((link) => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const category = link.getAttribute("data-category");

                // Show all books if "All" is selected, otherwise hide/show based on category
                if (category === "all") {
                    showAllBooks();
                } else {
                    bookCards.forEach((card) => {
                        const cardCategory = card.getAttribute("data-category");
                        if (cardCategory === category) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
                    });
                }
            });
        });
    });


        // script for buy 
document.querySelectorAll('.add-to-cart').forEach(function (button) {
    button.addEventListener('click', function (event) {
        event.preventDefault();
        const quantityInput = event.target.previousElementSibling; // Input field
        const quantity = parseInt(quantityInput.value, 10); // Parse the quantity as an integer
        const productId = event.target.getAttribute('data-product-id');

        if (isNaN(quantity) || quantity < 1) {
            alert('Please enter a valid quantity (1 or more).');
        } else if (quantity > parseInt(quantityInput.getAttribute('max'), 10)) {
            alert('Quantity exceeds the available quantity.');
        } else {
            // Check if the user is logged in
            <?php if (isset($_SESSION['id'])) : ?>
                const confirmation = confirm('Add ' + quantity + ' item(s) to your cart?');
                if (confirmation) {
                    // User is logged in, send the selected quantity and product ID to the server
                    addToCart(productId, quantity);
                }
            <?php else : ?>
                // User is not logged in, redirect to the login page
                window.location.href = '<?php echo $loginLink; ?>';
            <?php endif; ?>
        }
    });
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


</script>


</body>
</html>
<?php
$conn->close();
?>
