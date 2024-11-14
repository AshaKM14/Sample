<?php
include('db.php');

$message = ''; // Initialize the message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username, $email, $password])) {
        $message = "Registration successful! <br><a href='login.php'>Login here</a>";
    } else {
        $message = "Error registering user.";
    }
}
?>
<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
<center>
<h1 style="color:white;">Social Media Portal</h1>
<form method="POST" action="">
    <label style="font-size: 20px;"><b>Username:</b></label><br>
    <input type="text" name="username" required><br>
    <label style="font-size: 20px;"><b>Email:</b></label><br>
    <input type="email" name="email" required><br>
    <label style="font-size: 20px;"><b>Password:</b></label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit"><b>Register</b></button>
    <a href="login.php" style="text-decoration: none;">
        <button type="button"><b>Login</b></button>
    </a>
</form>
<div><?php echo $message; ?></div> <!-- Display message here -->
</center>
</body>
</html>
