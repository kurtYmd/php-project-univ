<?php
global $conn;

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Create a connection to the MySQL database (use your credentials)
require_once "db_connection.php";

// Fetch and display the user's blog posts
$username = $_SESSION["username"];
$selectQuery = "SELECT * FROM posts WHERE username = '$username'";
$result = $conn->query($selectQuery);

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

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="registration-form">
    <h2>Create New Blog Post</h2>
    <form method="POST" action="create_post.php">
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
