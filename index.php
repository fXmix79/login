<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Protected Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logout a {
            text-decoration: none;
            color: #fff;
            background-color: #ff0000;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
    <h1>Welcome to the protected page, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This page is only accessible to logged-in users.</p>
</body>
</html>
