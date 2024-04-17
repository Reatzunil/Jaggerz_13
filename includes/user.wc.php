<?php
require_once 'includes/dbh.inc.php';

// Assuming you have a user ID stored in a session variable
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details from user_details table based on user_id
    $sql = "SELECT username, password FROM user_details WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $password = $row['password'];

        // Use the fetched data as needed, for example, echo the username
        echo "Welcome, $username!";
    } else {
        echo "User not found.";
    }

    $stmt->close();
} else {
    echo "User ID not set.";
}
?>