<?php
global $conn;
require_once 'db_connect.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate form data (add more validation as per your requirements)
    if (empty($username) || empty($password)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Prepare the SQL statement to check if the user exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // User exists, set session variable to maintain logged-in state
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
<body>
<div class="registration-form">
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Login Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
</html>