<?php
session_start();
include "db_conn.php";

function validate($data, $field) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    if ($field === 'full_name') {
        // Check if full name contains only letters, no numbers or symbols
        if (!preg_match("/^[a-zA-Z ]+$/", $data)) {
            return false;
        }
        
        // Check if there are at least 5 letters in the full name
        $lettersCount = preg_match_all("/[a-zA-Z]/", $data);
        if ($lettersCount < 5) {
            return false;
        }
        
        // Check if there are no more than one consecutive space
        if (strpos($data, '  ') !== false) {
            return false;
        }
    }
    
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['full_name']) && isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['contact_info'])) {
        $full_name = validate($_POST['full_name'], 'full_name');
        $uname = validate($_POST['uname'], 'uname');
        $pass = validate($_POST['password'], 'password');
        $confirmPass = validate($_POST['confirm_password'], 'confirm_password');
        $contactInfo = validate($_POST['contact_info'], 'contact_info');

        if ($full_name === false || empty($uname) || empty($pass) || empty($confirmPass) || empty($contactInfo)) {
            header("Location: signup.php?error=Invalid full name format or all fields are required");
            exit();
        } elseif (strlen($pass) < 8) {
            header("Location: signup.php?error=Password should be at least 8 characters long");
            exit();
        } elseif ($pass !== $confirmPass) {
            header("Location: signup.php?error=Passwords do not match");
            exit();
        } else {
            // Check if username already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0) {
                header("Location: signup.php?error=Username already exists");
                exit();
            }

            // Check if Gmail address already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE contact_info=?");
            $stmt->bind_param("s", $contactInfo);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0) {
                header("Location: signup.php?error=Gmail address already in use");
                exit();
            }

            // Hash the password
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            // Insert user into the database with full name, username, password, and contact info
            $stmt = $conn->prepare("INSERT INTO users (full_name, user_name, password, contact_info) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $uname, $hashedPass, $contactInfo);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                header("Location: signup.php?error=Something went wrong");
                exit();
            }
        }
    } else {
        header("Location: signup.php");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
