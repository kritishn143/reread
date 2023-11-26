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

// Initialize variables to store search results
$search_results = array();

// Check if a search query is submitted
if (isset($_GET['search_query'])) {
    // Sanitize and escape the search query to prevent XSS
    $search_query = htmlspecialchars($_GET['search_query'], ENT_QUOTES, 'UTF-8');

    // Define the number of search results per page
    $resultsPerPage = 8;

    // Calculate the total number of pages
    $totalPages = ceil(count($search_results) / $resultsPerPage);

    // Get the current page from the URL, default to page 1
    $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

    // Calculate the offset to retrieve the results for the current page
    $offset = ($current_page - 1) * $resultsPerPage;

    // Modify the SQL query to retrieve results for the current page
    $sql_search = "SELECT * FROM products WHERE
                   (book_name LIKE '%" . $search_query . "%' OR
                    author LIKE '%" . $search_query . "%' OR
                    category LIKE '%" . $search_query . "%') AND
                    uploaded_by <> '$logged_in_user'
                   LIMIT $offset, $resultsPerPage";

    $result_search = $conn->query($sql_search);

    if ($result_search->num_rows > 0) {
        while ($row = $result_search->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="search-style.css">
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
                        <input type="text" name="search_query" placeholder="Search for books..." value="<?php echo isset($search_query) ? $search_query : ''; ?>">
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

    <section id="search-results" class="custom-search-results">
    <h2 class="custom-search-header">Search Results</h2>
    <?php if (isset($search_query)) : ?>
        <p class="custom-search-query">Showing results for: "<?php echo $search_query; ?>"</p>
    <?php endif; ?>

    <?php if (count($search_results) > 0) : ?>
        <div class="custom-book-cards">
    <?php foreach ($search_results as $result) : ?>
        
        <div class="custom-book-card" data-category="<?php echo $result['category']; ?>">
        <h3 class="custom-book-name">
                <a href="book_details.php?book_id=<?php echo $result['id']; ?>">
                    <?php echo $result['book_name']; ?>
                </a>
            </h3>   
        <img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $result['image']); ?>"
                 alt="Book Cover" class="custom-book-image">
            <p>Price: NPR<?php echo $result['price']; ?></p>
            
        </div>
    <?php endforeach; ?>
</div>

    <?php else : ?>
        <p class="custom-no-results">No results found.</p>
    <?php endif; ?>
</section>

    <div class="pagination">
        <?php if (isset($search_query) && $totalPages > 1) : ?>
            <?php if ($current_page > 1) : ?>
                <a href="search.php?search_query=<?php echo urlencode($search_query); ?>&page=<?php echo ($current_page - 1); ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="search.php?search_query=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>" <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $totalPages) : ?>
                <a href="search.php?search_query=<?php echo urlencode($search_query); ?>&page=<?php echo ($current_page + 1); ?>">Next</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

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

    <script>
// Function to update the page title
function updateTitle() {
    const searchQuery = document.querySelector(".search-form input[name='search_query']").value;
    document.title = `Search Books${searchQuery ? ' - ' + searchQuery : ''}`;
}

// Call the function when the page loads
window.addEventListener("load", updateTitle);

// Call the function when the search form is submitted
document.querySelector(".search-form").addEventListener("submit", updateTitle);


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
