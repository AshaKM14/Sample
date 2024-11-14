<?php
session_start();
include('db.php');

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['user_id'];

    // Insert the post into the database
    $sql = "INSERT INTO posts (user_id, post_content) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $post_content]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Feed</title>
    <style>
        body {
            background-image: url('feed.jpg'); /* Change the path to your image */
            background-size: cover; /* This will make the image cover the whole background */
            color: white; /* Change text color for better visibility */
            text-align: center; /* Centering the text */
        }
        textarea {
            width: 80%; /* Set width for textarea */
            height: 100px; /* Set height for textarea */
        }
        button {
            margin: 10px; /* Add some margin around buttons */
            background-color:#151B54; /* Set button background color to blue */
            color: white; /* Set text color to white for contrast */
            border: 4px; /* Remove border */
            padding: 10px 20px; /* Add padding for a better appearance */
            cursor: pointer; /* Change cursor to pointer */
            font-size: 16px; /* Increase font size */
        }
        button:hover {
            background-color: cyon; /* Change color on hover for better interaction */
        }
    </style>
</head>
<body>

<center>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
</center>

<!-- Post a message -->
<form method="POST" action="">
<center>
    <textarea name="post_content" required placeholder="What's on your mind?"></textarea><br><br>
    <button type="submit"><b>Post</button>
</center>
</form>

<!-- Logout Button -->
<form method="POST" action="logout.php" style="display:inline;">
    <button type="submit"><b>Logout</button>
</form>

<h3 style="color:black;"><b>Your Feed :</h3>
<?php
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

foreach ($posts as $post) {
    echo "<p><strong>" . htmlspecialchars($post['username']) . ":</strong> " . htmlspecialchars($post['post_content']) . "</p>";
}
?>

</body>
</html>
