<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    // Get updated profile information from the form
    $newLocation = $_POST['location'];

    // Handle profile picture upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $avatar_name = 'profile_picture_' . time() . '.jpg'; // Unique filename
        $avatar_destination = __DIR__ . "/images/profiles/" . $avatar_name;

        // Create the directory if it doesn't exist
        if (!is_dir(__DIR__ . "/images/profiles/")) {
            mkdir(__DIR__ . "/images/profiles/", 0777, true); // Creates directory recursively with full permissions
        }

        // Move the uploaded file to the destination
        if (move_uploaded_file($avatar_tmp, $avatar_destination)) {
            // Update the user's profile picture path and location in the database
            $updateSql = "UPDATE users SET location = '$newLocation', profile_picture = '$avatar_name' WHERE user_name = '$user_name'";
            if ($conn->query($updateSql) === TRUE) {
                $_SESSION['profile_updated'] = true;
                header("Location: userdashboard.php");
                exit();
            } else {
                echo "Error updating profile: " . $conn->error;
            }
        } else {
            echo "Error uploading profile picture.";
        }
    } else {
        // Update only location if no profile picture is uploaded
        $updateSql = "UPDATE users SET location = '$newLocation' WHERE user_name = '$user_name'";
        if ($conn->query($updateSql) === TRUE) {
            $_SESSION['profile_updated'] = true; // Set a session variable
            header("Location: userdashboard.php"); // Redirect to userdashboard.php
            exit();
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    }

    $conn->close();
}
?>
