<?php
global $conn;
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate form data (add more validation as per your requirements)
    if (empty($username) || empty($password)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
        exit;
    }

    // Insert the user details into the "users" table
    $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="registration-form">
        <h2>User Registration</h2>
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <div class="submit-btn">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>
</html>
