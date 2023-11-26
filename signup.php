<?php
session_start(); // Start the session if it's not already started
$loginLink = "login.php";
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
    <title>Sign Up | Reread </title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="gallery-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="signup-style.css">
    <link rel="icon" href="video/reread.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
<section class="signup-container"> <!-- Add this section -->
        <div class="signup-container">
            <form action="signup_process.php" method="post">
                <h2>Sign Up</h2>
                <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <div class="input-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                    <p class="name-error" style="color: red;"></p> <!-- Error message for full name validation -->
                </div>
                <div class="input-group">
                    <label for="contact_info">Email</label>
                    <input type="email" id="contact_info" name="contact_info" placeholder="Enter your Gmail address" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" title="Please enter a valid Gmail address" required>
                </div>
                <div class="input-group">
                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="uname" placeholder="Username will be auto-generated" readonly>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" pattern="^(?=.*[A-Z])(?=.*[!@#$%]).{6,}$" title="Password must contain at least 1 uppercase letter and 3 symbols from !@#$%" required>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
                <div class="signup-link">
                    <div class="or-line">
                        <span></span>
                        <span class="or">or</span>
                        <span></span>
                    </div>
                    <p>Already have an account? <a href="login.php">Log In</a></p>
                </div>
            </form>
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
          
        </ul>
    </div>
</section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> REREAD. All rights reserved</p>
    </footer>
 <script>
        document.addEventListener("DOMContentLoaded", function () {
    const fullNameInput = document.getElementById("full_name");
    const usernameInput = document.getElementById("uname");
    const nameError = document.querySelector(".name-error");

    fullNameInput.addEventListener("input", function () {
        const fullName = fullNameInput.value.trim(); // Remove leading and trailing spaces
        if (fullName.length < 5) {
            nameError.textContent = "Please input a full name with at least 5 characters.";
        } else {
            nameError.textContent = "";
            const username = generateUsername(fullName);
            usernameInput.value = username;
        }
    });

    function generateUsername(fullName) {
        const fullNameWithoutSpaces = fullName.replace(/\s+/g, ''); // Remove all spaces
        const letters = fullNameWithoutSpaces.substring(0, 7).toLowerCase();
        const randomNumbers = Array.from({ length: 3 }, () => Math.floor(Math.random() * 9) + 1).join("");
        const username = letters + randomNumbers;
        return username;
    }
});

    </script>
</body>
</html>
