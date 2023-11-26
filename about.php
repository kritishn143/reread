<?php
session_start();

$loginLink = "login.php";

// You can add other necessary variables here if needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - REREAD</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="aboutus.css">
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

    <!-- About Us Content -->
    <section class="about-us">
        <h1>Welcome to Reread: Where Every Book Tells a Story</h1>
        <p>At Reread, we're not just a marketplace; we're the premier online destination for book enthusiasts like you. We've created a curated haven for literary treasures where stories find new beginnings. Whether you're a passionate reader looking to declutter your bookshelf or a devoted bibliophile in search of your next literary adventure, Reread is where it all happens.</p>

        <h2>"Where Stories Find New Beginnings"</h2>
        <p>📚 Dive into a world of wonder and rediscover the magic within the pages of your favorite books. At Reread, every book is a hidden gem waiting to be uncovered.</p>
        <p>📖 Give your bookshelf a fresh start and let your books embark on their second chapter with new owners who will cherish them as much as you did.</p>
        <p>📕 Reread is more than just a marketplace; it's a community of book lovers united by their passion for reading. Join us in connecting with fellow enthusiasts, one page at a time.</p>

        <h3>Share the Joy of Reading, Share the Love of Reread</h3>
        <p>📗 Share your love for reading and the joy of discovering new stories with Reread. Together, we can spread the magic of books and build a community of book enthusiasts who cherish every page.</p>

        <p>Join Reread today and be a part of a thriving community where books are reimagined, recherished, and where every book tells a story. Explore our collection, connect with fellow book lovers, and let the adventure begin!</p>
    </section>

    <section class="footer-bar">
        <div class="footer-logo"> 
            <img src="video/logo.gif" alt="REREAD Logo" width="100">
            <p>Rediscover the Magic of Books.</p>
        </div>
        <div class="helpful-links">
            <h1>Helpful Links</h1>
            <ul>
                <li><a href="#">About us</a></li>
              
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

<?php
// You can close any database connections or perform other cleanup here if needed
?>
