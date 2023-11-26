<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Example database connection (replace with your actual database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user_name from the session
$user_name = $_SESSION['user_name'];

// Example user profile data retrieval (replace with actual query)
$sql = "SELECT user_name, location, profile_picture FROM users WHERE user_name = '$user_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userProfile = array(
        'name' => $row['user_name'],
        'location' => $row['location'],
        'avatar' => $row['profile_picture'],
        // ... other profile information
    );
} else {
    echo "No user found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="video/reread.ico" type="image/x-icon">
    <style>
        /* Additional styling for edit-profile.php */
        .edit-profile-box {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto 20px; /* Center horizontally and add margin at the bottom */
            max-width: 400px; /* Limit the width of the box */
        }

        .edit-profile-form label,
        .edit-profile-form input {
            display: block;
            margin-bottom: 10px;
        }

        .edit-profile-form button {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        
    </style>
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
                <li><a href="userdashboard.php">Dashboard</a></li>
                <li><a href="upload.php">Upload</a></li>
                <li class="top-right"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <section class="content">
            <div class="edit-profile-box">
                <h2>Edit Profile</h2>
                <form action="update-profile.php" method="post" enctype="multipart/form-data" class="edit-profile-form">
                    <label for="avatar">Profile Picture:</label>
                    <input type="file" name="avatar" id="avatar">
                    <label for="location">Location:</label>
<input type="text" name="location" id="location" value="<?php echo $userProfile['location']; ?>" required>

                    <!-- Add other fields for profile update -->
                    <button type="submit">Save Changes</button>
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
                <li><a href="about.php"><i class="fab fa-facebook"></i></a></li>
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
