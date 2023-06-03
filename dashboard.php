<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Create a connection to the MySQL database (use your credentials)
require_once "db_connect.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $content = $_POST["content"];
    $username = $_SESSION["username"];

    // Validate form data (add more validation as per your requirements)
    if (empty($title) || empty($content)) {
        echo "Please fill in all the fields.";
        exit;
    }

    // Insert the new blog post into the "posts" table
    $insertQuery = "INSERT INTO posts (title, content, username, published_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $title, $content, $username);

    if ($stmt->execute()) {
        echo "New blog post created successfully!";
    } else {
        echo "Error creating blog post: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch and display the user's blog posts
$username = $_SESSION["username"];
$selectQuery = "SELECT * FROM posts WHERE username = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Your Blog Posts</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>Title: " . $row["title"] . "</h3>";
        echo "<p>Content: " . $row["content"] . "</p>";
        echo "<p>Published Date: " . $row["published_date"] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No blog posts found.</p>";
}

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Dashboard</title>
</head>
<body>
<form action="logout.php" method="post">
    <input type="submit" value="Logout">
</form>
<div class="registration-form">
    <h2>Create New Blog Post</h2>
    <form method="POST" action="dashboard.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <br><br>
        <input type="submit" value="Create Post">
    </form>
</div>
</body>
</html>


