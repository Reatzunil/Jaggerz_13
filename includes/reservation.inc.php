<?php

require_once 'includes/dbh.inc.php'; // Include your database connection file


?>

/*
// Include your database connection file
require_once 'includes/dbh.inc.php';

// Check if the form was submitted
if (isset($_POST['register'])) {
    // Validate and sanitize form data
    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $number = isset($_POST['number']) ? htmlspecialchars($_POST['number']) : "";
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : "";
    $image_path = ""; // Initialize for file upload

    // Handle file upload
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // Specify the target directory for file upload
        $target_dir = "uploads/";
        // Generate a unique file name to prevent overwriting
        $image_name = uniqid() . '_' . basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $image_name;

        // Check file size and allowed file types
        if ($_FILES["file"]["size"] > 500000) {
            echo "Error: File is too large.";
        } elseif (!in_array(strtolower(pathinfo($target_file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            echo "Error: Only JPG, JPEG, PNG files are allowed.";
        } elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // File uploaded successfully, set $image_path
            $image_path = $target_file;
        } else {
            echo "Error uploading file.";
        }
    }

    // Check if all required fields are filled
    if (empty($username) || empty($password) || empty($number) || empty($email) || empty($image_path)) {
        echo "Error: Please fill in all required fields.";
    } else {
        // Now you can insert this data into your database
        $sql = "INSERT INTO user_details (username, password, number, email, image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $number, $email, $image_path);

        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful";
        } else {
            // Registration failed
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>