<?php
session_start();
include('db.php');

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch the user from the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: feed.php"); // Redirect to feed page
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!-- Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('sample.jpg'); /* Set the background image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items at the top */
            height: 100vh; /* Full height of the viewport */
            margin: 0;
            color: white; /* Change text color if necessary */
        }
        form {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 50px; /* Space from the top */
        }
        label {
            display: block;
            margin: 10px 0 5px; /* Adjusted margin */
        }
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            font-size: 1.1em;
            text-align: center; /* Center the message */
        }
    </style>
</head>
<body>
<center>
<h1 style="text-align: center; margin-top: 20px; color: white;">Login</h1> <!-- Centered heading -->
<form method="POST" action="">
    <label style="color: black;"><b>Email:</b></label>
    <input type="email" name="email" required>
    
    <label style="color: black;"><b>Password:</b></label>
    <input type="password" name="password" required>
    
    <button type="submit"><b>Sign in</b></button>
</form>
<div class="message"><?php echo htmlspecialchars($message); ?></div> <!-- Display message safely -->
</center>
</body>
</html>
