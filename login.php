<?php
session_start(); // Start the session if it's not already started

if (isset($_SESSION['id'])) {
    // User is already logged in, redirect to index.php
    header("Location: index.php");
    exit(); // Make sure to exit after the redirection
}

// Rest of your HTML and PHP code for signup.php goes here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Reread </title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="style.css">
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
                        <a href="signup.php" class="signup-button">
    <i class="fas fa-user-plus"></i></a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Login Form Container -->
    <div class="container login-container">
        <form action="login_process.php" method="post">
            <h2>Login</h2>
            <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <div class="input-group">
                <label for="uname">Username</label>
                <input type="text" id="uname" name="uname" placeholder="Enter your username" required />
            </div>

            <div class="password-forgot">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required />
                <div class="forgot-remember">
                    <div class="left-side">
                        <!-- Add any additional elements related to password recovery or remember me here -->
                    </div>
                </div>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="or-line">
                <span></span>
                <span class="or">or</span>
                <span></span>
            </div>

            <div class="signup-link">
                <p>Not a member yet? <a href="signup.php">Create new Account</a></p>
            </div>
        </form>
    </div>

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
            </ul>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> REREAD. All rights reserved</p>
    </footer>
</body>
</html>

