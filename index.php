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
$logged_in_user = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';


$sql_gallery = "SELECT * FROM products WHERE uploaded_by <> ?";
$stmt = $conn->prepare($sql_gallery);
$stmt->bind_param("s", $logged_in_user);
$stmt->execute();
$result_gallery = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | REREAD</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                  <input type="text" name="search_query" placeholder="<?php echo htmlspecialchars("Search for books..."); ?>">

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
   
 
    <section class="intro">
        <div class="intro-text">
            <h1>Where Every Book Tells <br> A Story</h1>
            <p>The Premier Destination for Book Thrifting</p>
            <!-- Add your "Browse Books" button here -->
            <a href="gallery.php" class="browse-button">Browse Books</a>
        </div>
        <div class="video-section">
            <video id="intro-video" width="3840" height="2160" autoplay loop muted>
                <source src="video/reread.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

   


    <!-- Add this code just above your footer section -->
<section class="footer-bar">
    <div class="footer-logo"> 
        <img src="video/logo.gif" alt="REREAD Logo" width="100">
        <p>Rediscover the Magic of Books.</p>
    </div>
    <div class="helpful-links">
        <h1>Helpful Links</h1>
        <ul>
            <li><a href="about.php" >About us</a></li>
           
           
            <!-- Add more links as needed -->
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
    const video = document.getElementById('intro-video');

    document.addEventListener("DOMContentLoaded", function () {
        const filterLinks = document.querySelectorAll(".filter-list a");
        const bookCards = document.querySelectorAll(".book-card");
        const bookCardsContainer = document.querySelector(".book-cards"); // New line

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

    // Check if Local Storage supports the video playback position
    if (localStorage.getItem('videoPosition')) {
        const savedPosition = parseFloat(localStorage.getItem('videoPosition'));

        // Set the saved position as the current time
        if (!isNaN(savedPosition)) {
            video.currentTime = savedPosition;
        }
    }

    // Save the video playback position when the video pauses
    video.addEventListener('pause', () => {
        localStorage.setItem('videoPosition', video.currentTime.toString());
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
