<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Clear the session variable after displaying the message
if (isset($_SESSION['profile_updated']) && $_SESSION['profile_updated']) {
    echo '<script>alert("Profile updated successfully.");</script>';
    $_SESSION['profile_updated'] = false; // Reset the session variable
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_name = $_SESSION['user_name'];

$sql = "SELECT user_name, location, profile_picture FROM users WHERE user_name = '$user_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userProfile = array(
        'name' => $row['user_name'],
        'location' => $row['location'],
        'avatar' => $row['profile_picture'],
      
    );
} else {
    echo "No user found.";
}

// Retrieve only images uploaded by the logged-in user
$sql_gallery = "SELECT * FROM products WHERE uploaded_by = '$user_name'";
$result_gallery = $conn->query($sql_gallery);
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

    <main class="dashboard-container">
        <section class="content">
            <div class="user-profile">
            <h2>Your Profile</h2>
    <img src="/images/profiles/<?php echo $userProfile['avatar']; ?>" alt="Profile Picture">
    <p><strong>Username:</strong> <?php echo $userProfile['name']; ?></p>
    <p><strong>Location:</strong> <?php echo $userProfile['location']; ?></p>
   <a href="edit-profile.php" class="edit-profile-button">Edit Profile</a>
            </div>
        </section>
    </main>


    <section class="content">
    <div class="image-gallery">
    <?php while ($row_gallery = $result_gallery->fetch_assoc()): ?>
        <div class="image-container">
            <img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $row_gallery['image']); ?>" alt="Uploaded Image">
            <div class="image-info">
                <p>Author: <?php echo $row_gallery['author']; ?></p>
                <p>Category: <?php echo $row_gallery['category']; ?></p>
                <p>Book Name: <?php echo $row_gallery['book_name']; ?></p>
                <p>Price: NPR<?php echo $row_gallery['price']; ?></p>
                <p>Condition: <?php echo $row_gallery['condition']; ?></p> <!-- Add this line for displaying condition -->
                <p>Available Quantity: <?php echo $row_gallery['quantity_available']; ?></p>
                <a href="edit-item.php?id=<?php echo $row_gallery['id']; ?>">Edit</a>
                <a href="delete-item.php?id=<?php echo $row_gallery['id']; ?>">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
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

<?php
$conn->close();
?>
