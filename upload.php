<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload | Reread</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="upload-style.css">
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
                <li><a href="index.php">Home</a></li>
                <li><a href="userdashboard.php">Profile</a></li>
                <li><a href="order.php">Carts</a></li>
                <li class="top-right"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <section class="content">
            <div class="upload-section">
                <h2>Upload Pictures</h2>
                <form action="upload-handler.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Select Image:</label>
                        <input type="file" name="image" id="image" accept="image/*" required>
                    </div>
                    
                   
                    
                    <div class="form-group">
                        <label for="author">Author (20 characters):</label>
                        <input type="text" name="author" id="author" maxlength="20" required>
                    </div>
                    <div class="form-group">
    <label for="condition">Condition:</label>
    <select name="condition" id="condition" required>
        <option value="New">New</option>
        <option value="Like New">Like New</option>
        <option value="Excellent">Excellent</option>
        <option value="Good">Good</option>
        <option value="Fair">Fair</option>
        <option value="Poor">Poor</option>
        <!-- Add more condition options as needed -->
    </select>
</div>

                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" id="category" required>
                            <option value="Biographies">Biographies</option>
                            <option value="Children's Books">Children's Books</option>
                            <option value="Education & Reference">Education & Reference</option>
                            <!-- Add more options for other categories -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="book_name">Book Name:</label>
                        <input type="text" name="book_name" id="book_name" maxlength="100" required>
                    </div>
                    
                    <div class="form-group">
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" min="0.01" step="0.01" required>
</div>

<div class="form-group">
    <label for="quantity">Quantity Available:</label>
    <input type="number" name="quantity" id="quantity" min="1" value="1" required>
</div>

<div class="form-group">
    <input type="submit" value="Upload">
</div>
                    
                </form>
            </div>
        </section>
    </main>
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
