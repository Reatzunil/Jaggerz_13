<?php
// Start the session
session_start();

// Include the database connection file
require_once 'includes/connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to check username and password
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row with matching username and password exists
    if ($result->num_rows == 1) {
        // Username and password are correct, redirect to another page
        header("Location: user.php");
        exit(); // Stop further execution
    } else {
        // Username or password is incorrect, display an error message or handle it as needed
        echo "Invalid username or password.";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>