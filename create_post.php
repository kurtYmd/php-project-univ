<?php
global $conn;

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $content = $_POST["content"];

    // Create a connection to the MySQL database (use your credentials)
    require_once "db_connection.php";

    // Retrieve the username from the session
    $username = $_SESSION["username"];

    // Insert the new blog post into the "posts" table
    $insertQuery = "INSERT INTO posts (username, title, content) VALUES ('$username', '$title', '$content')";

    if ($conn->query($insertQuery) === TRUE) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error creating blog post: " . $conn->error;
    }

    $conn->close();
}
?>
