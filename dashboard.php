<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

require_once "db_connect.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

